#!/bin/bash

printf "\nVerifying credentials\n\n"

aws sts get-caller-identity &> /dev/null
credentialsCorrect=$?
if [ $credentialsCorrect -ne 0 ]
then
	italic_start="\e[3m"
	italic_end="\e[0m"
	credentials_file="$italic_start~/.aws/credentials$italic_end"
	printf "Could not verify your AWS credentials.\nPlease update your credential file in \
		\n\n$credentials_file \n\nor run the command: \n\naws configure\n"
	exit $credentialsCorrect
fi
AVAILABILITY_ZONE="us-east-1"
VPC_CIDR="10.0.0.0/16"
VPC_NAME="vpc-$AVAILABILITY_ZONE-quickreg"
printf "Creating VPC: $VPC_NAME\n\n"
VPC_ID=`aws ec2 create-vpc --cidr-block 10.0.0.0/16 \
	--query 'Vpc.{VpcId:VpcId}' --output text`
aws ec2 create-tags --resources $VPC_ID --tags Key=Name,Value="$VPC_NAME"

INTERNET_GATEWAY_NAME="internet-gateway-$AVAILABILITY_ZONE-quickreg"
printf "Creating Internet Gateway: $INTERNET_GATEWAY_NAME\n"
INTERNET_GATEWAY_ID=`aws ec2 create-internet-gateway \
	--query 'InternetGateway.{InternetGatewayId:InternetGatewayId}' --output text`
aws ec2 create-tags --resources $INTERNET_GATEWAY_ID \
	--tags Key=Name,Value="$INTERNET_GATEWAY_NAME"
printf "Attaching Internet Gateway: $INTERNET_GATEWAY_NAME to VPC: $VPC_NAME\n\n"
aws ec2 attach-internet-gateway --vpc-id $VPC_ID \
	--internet-gateway-id $INTERNET_GATEWAY_ID

printf "Creating Route Table\n"
ROUTE_TABLE_ID=`aws ec2 create-route-table --vpc-id $VPC_ID \
	--query 'RouteTable.{RouteTableId:RouteTableId}' --output text`
ROUTE_TABLE_NAME="route-table-$AVAILABILITY_ZONE-quickreg"
aws ec2 create-tags --resources $ROUTE_TABLE_ID \
	--tags Key=Name,Value="$ROUTE_TABLE_NAME"
printf "Creating Route: $ROUTE_TABLE_NAME\n\n"
ANYWHERE="0.0.0.0/0"
aws ec2 create-route --route-table-id $ROUTE_TABLE_ID \
	--destination-cidr-block $ANYWHERE --gateway-id $INTERNET_GATEWAY_ID > /dev/null


SUBNET_NAME_PUBLIC_ONE="subnet-$AVAILABILITY_ZONE-quickreg-public-1"
printf "Creating subnet: $SUBNET_NAME_PUBLIC_ONE\n"
SUBNET_CIDR_PUBLIC_ONE="10.0.0.0/24"
# TODO Find method of concatenating strings that is easier to read
SUBNET_AVAILABILITY_ZONE_PUBLIC_ONE="${AVAILABILITY_ZONE}a"
SUBNET_ID_PUBLIC_ONE=`aws ec2 create-subnet --cidr-block $SUBNET_CIDR_PUBLIC_ONE \
	--vpc-id $VPC_ID --availability-zone $SUBNET_AVAILABILITY_ZONE_PUBLIC_ONE \
	--query 'Subnet.{SubnetId:SubnetId}' --output text`
aws ec2 create-tags --resources $SUBNET_ID_PUBLIC_ONE \
	--tags Key=Name,Value="$SUBNET_NAME_PUBLIC_ONE"

printf "Making subnet: $SUBNET_NAME_PUBLIC_ONE publicly accessible\n\n"
aws ec2 associate-route-table \
	--route-table-id $ROUTE_TABLE_ID \
	--subnet-id $SUBNET_ID_PUBLIC_ONE > /dev/null

aws ec2 modify-subnet-attribute \
	--subnet-id $SUBNET_ID_PUBLIC_ONE \
	--map-public-ip-on-launch


SUBNET_NAME_PRIVATE_ONE="subnet-$AVAILABILITY_ZONE-quickreg-private-1"
printf "Creating subnet: $SUBNET_NAME_PRIVATE_ONE\n\n"
SUBNET_CIDR_PRIVATE_ONE="10.0.1.0/24"
SUBNET_AVAILABILITY_ZONE_PRIVATE_ONE="${AVAILABILITY_ZONE}a"
SUBNET_ID_PRIVATE_ONE=`aws ec2 create-subnet --cidr-block $SUBNET_CIDR_PRIVATE_ONE \
	--vpc-id $VPC_ID --availability-zone $SUBNET_AVAILABILITY_ZONE_PRIVATE_ONE \
	--query 'Subnet.{SubnetId:SubnetId}' --output text`
aws ec2 create-tags --resources $SUBNET_ID_PRIVATE_ONE \
	--tags Key=Name,Value="$SUBNET_NAME_PRIVATE_ONE"

SUBNET_NAME_PRIVATE_TWO="subnet-$AVAILABILITY_ZONE-quickreg-private-1"
printf "Creating subnet: $SUBNET_NAME_PRIVATE_TWO\n\n"
SUBNET_CIDR_PRIVATE_TWO="10.0.2.0/24"
SUBNET_AVAILABILITY_ZONE_PRIVATE_TWO="${AVAILABILITY_ZONE}b"
SUBNET_ID_PRIVATE_TWO=`aws ec2 create-subnet --cidr-block $SUBNET_CIDR_PRIVATE_TWO \
	--vpc-id $VPC_ID --availability-zone $SUBNET_AVAILABILITY_ZONE_PRIVATE_TWO \
	--query 'Subnet.{SubnetId:SubnetId}' --output text`
aws ec2 create-tags --resources $SUBNET_ID_PRIVATE_TWO \
	--tags Key=Name,Value="$SUBNET_NAME_PRIVATE_TWO"

SECURITY_GROUP_WEBSERVER_NAME="security-group-web-server"
printf "Creating security group: $SECURITY_GROUP_WEBSERVER_NAME\n\n"
SECURITY_GROUP_WEBSERVER_DESCRIPTION="Security Group for EC2 instance running a web server"
SECURITY_GROUP_WEBSERVER_ID=`aws ec2 create-security-group \
	--group-name $SECURITY_GROUP_WEBSERVER_NAME \
	--description "$SECURITY_GROUP_WEBSERVER_DESCRIPTION" \
	--vpc-id $VPC_ID \
	--query 'GroupId' --output text`
# printf "Security Group Web Server ID: $SECURITY_GROUP_WEBSERVER_ID\n\n"

KEY_PAIR_NAME="key-pair-quickreg"
KEY_PAIR_PATH="$KEY_PAIR_NAME.pem"
printf "Creating key pair: $KEY_PAIR_NAME\n"
aws ec2 create-key-pair --key-name $KEY_PAIR_NAME --query 'KeyMaterial' --output text > $KEY_PAIR_NAME
chmod 400 "$KEY_PAIR_NAME"
printf "Created key pair: $KEY_PAIR_NAME at $KEY_PAIR_PATH\n\n"
printf "Finished\n\n"

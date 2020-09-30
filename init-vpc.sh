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

VPC_CIDR="10.0.0.0/16"
VPC_NAME="vpc-us-east-1-quickreg"
printf "Creating VPC: $VPC_NAME\n\n"
VPC_ID=`aws ec2 create-vpc --cidr-block 10.0.0.0/16 \
	--query 'Vpc.{VpcId:VpcId}' --output text`
aws ec2 create-tags --resources $VPC_ID --tags Key=Name,Value="$VPC_NAME"

printf "Creating Internet Gateway\n"
INTERNET_GATEWAY_ID=`aws ec2 create-internet-gateway \
	--query 'InternetGateway.{InternetGatewayId:InternetGatewayId}' --output text`
INTERNET_GATEWAY_NAME="internet-gateway-us-east-1-quickreg"
aws ec2 create-tags --resources $INTERNET_GATEWAY_ID \
	--tags Key=Name,Value="$INTERNET_GATEWAY_NAME"
printf "Attaching Internet Gateway\n\n"
aws ec2 attach-internet-gateway --vpc-id $VPC_ID \
	--internet-gateway-id $INTERNET_GATEWAY_ID

printf "Creating Route Table\n"
ROUTE_TABLE_ID=`aws ec2 create-route-table --vpc-id $VPC_ID \
	--query 'RouteTable.{RouteTableId:RouteTableId}' --output text`
ROUTE_TABLE_NAME="route-table-us-east-1-quickreg"
aws ec2 create-tags --resources $ROUTE_TABLE_ID \
	--tags Key=Name,Value="$ROUTE_TABLE_NAME"
printf "Creating Route\n\n"
ANYWHERE="0.0.0.0/0"
aws ec2 create-route --route-table-id $ROUTE_TABLE_ID \
	--destination-cidr-block $ANYWHERE --gateway-id $INTERNET_GATEWAY_ID > /dev/null


SUBNET_NAME_PUBLIC_ONE="subnet-us-east-1-quickreg-public-1"
printf "Creating subnet: $SUBNET_NAME_PUBLIC_ONE\n"
SUBNET_CIDR_PUBLIC_ONE="10.0.0.0/24"
SUBNET_ID_PUBLIC_ONE=`aws ec2 create-subnet --cidr-block $SUBNET_CIDR_PUBLIC_ONE \
	--vpc-id $VPC_ID --query 'Subnet.{SubnetId:SubnetId}' --output text`
aws ec2 create-tags --resources $SUBNET_ID_PUBLIC_ONE \
	--tags Key=Name,Value="$SUBNET_NAME_PUBLIC_ONE"

printf "Making subnet: $SUBNET_NAME_PUBLIC_ONE publicly accessible\n"
aws ec2 associate-route-table \
	--route-table-id $ROUTE_TABLE_ID \
	--subnet-id $SUBNET_ID_PUBLIC_ONE > /dev/null

aws ec2 modify-subnet-attribute \
	--subnet-id $SUBNET_ID_PUBLIC_ONE \
	--map-public-ip-on-launch


SUBNET_NAME_PRIVATE_ONE="subnet-us-east-1-quickreg-private-1"
printf "Creating subnet: $SUBNET_NAME_PRIVATE_ONE\n\n"
SUBNET_CIDR_PRIVATE_ONE="10.0.1.0/24"
SUBNET_ID_PRIVATE_ONE=`aws ec2 create-subnet --cidr-block $SUBNET_CIDR_PRIVATE_ONE \
	--vpc-id $VPC_ID --query 'Subnet.{SubnetId:SubnetId}' --output text`
aws ec2 create-tags --resources $SUBNET_ID_PRIVATE_ONE \
	--tags Key=Name,Value="$SUBNET_NAME_PRIVATE_ONE"

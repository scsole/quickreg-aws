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
VPC_ID=`aws ec2 create-vpc --cidr-block 10.0.0.0/16 --query 'Vpc.{VpcId:VpcId}' --output text`
aws ec2 create-tags --resources $VPC_ID --tags Key=Name,Value="$VPC_NAME"


SUBNET_NAME_PUBLIC_ONE="subnet-us-east-1-quickreg-public-1"
printf "Creating subnet: $SUBNET_NAME_PUBLIC_ONE\n\n"
SUBNET_CIDR_PUBLIC_ONE="10.0.0.0/24"
SUBNET_ID_PUBLIC_ONE=`aws ec2 create-subnet --cidr-block $SUBNET_CIDR_PUBLIC_ONE \
	--vpc-id $VPC_ID --query 'Subnet.{SubnetId:SubnetId}' --output text`
aws ec2 create-tags --resources $SUBNET_ID_PUBLIC_ONE --tags Key=Name,Value="$SUBNET_NAME_PUBLIC_ONE"
# SUBNET_PUBLIC_TWO_NAME

#!/bin/bash
printf "\nVerifying credentials\n"
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
VPC_CIDR=10.0.0.0/16
printf "Creating VPC\n"
VPC_ID=`aws ec2 create-vpc --cidr-block 10.0.0.0/16 --query 'Vpc.{VpcId:VpcId}' --output text`
VPC_NAME="vpc-us-east-1-quickreg"
aws ec2 create-tags --resources $VPC_ID --tags Key=Name,Value="$VPC_NAME"


# aws ec2 create-subnet 

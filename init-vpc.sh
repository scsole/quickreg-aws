#!/bin/bash

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

aws ec2 create-vpc --cidr-block $VPC_CIDR --query "Vpc[-1].VpcId" --output text

# aws ec2 create-subnet 

#!/bin/bash

aws sts get-caller-identity
credentialsCorrect=$?
if [ $credentialsCorrect -ne 0 ]  then
	printf "\n\nCould not verify your credentials\n"
	exit $credentialsCorrect
fi
VPC_CIDR=10.0.0.0/16

aws ec2 create-vpc --cidr-block $VPC_CIDR

# aws ec2 create-subnet 

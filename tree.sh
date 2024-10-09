#!/bin/bash

# Check if the tree command is available
if ! command -v tree &> /dev/null
then
    echo "The 'tree' command is not installed. Please install it to run this script."
    exit 1
fi

# Get the directory to print
DIRECTORY=${1:-.}  # Default to current directory if no argument is provided

# Print the directory structure
echo "Directory structure for: $DIRECTORY"
tree "$DIRECTORY"

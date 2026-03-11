#!/bin/bash

# Switch between environment files
# Usage: ./switch-env.sh [development|production|local]

ENV_FILE=${1:-"development"}

if [[ ! -f ".env.$ENV_FILE" ]]; then
    echo "Error: .env.$ENV_FILE does not exist"
    echo "Available files:"
    ls -la .env* | grep -v ".env.backup"
    exit 1
fi

# Backup current .env
if [[ -f ".env" ]]; then
    cp .env .env.backup.$(date +%Y%m%d_%H%M%S)
fi

# Switch to new environment
cp ".env.$ENV_FILE" .env

echo "Switched to .env.$ENV_FILE"
echo "Current environment:"
grep "APP_ENV\|APP_URL" .env

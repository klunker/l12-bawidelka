#!/bin/bash

# Act - GitHub Actions local runner (alternative to Docker)
# Usage: ./run-act.sh [lint|tests|all]

set -e

# Source common functions
source "$(dirname "$0")/common.sh"

# Colors are now loaded from common.sh

# Check if act is installed
if ! command -v act &> /dev/null; then
    print_warning "Act is not installed. Installing..."
    
    # Check if we're on Linux/macOS
    if [[ "$OSTYPE" == "linux-gnu"* ]]; then
        # Linux
        curl https://raw.githubusercontent.com/nektos/act/master/install.sh | sudo bash
    elif [[ "$OSTYPE" == "darwin"* ]]; then
        # macOS
        brew install act
    else
        print_error "Unsupported OS. Please install act manually: https://github.com/nektos/act"
        exit 1
    fi
    
    if ! command -v act &> /dev/null; then
        print_error "Failed to install act"
        exit 1
    fi
    
    print_success "Act installed successfully!"
fi

# Parse arguments
ACTION=${1:-"all"}
WORKFLOW=${2:-""}

print_header "Act - GitHub Actions Local Runner"
print_status "Using Act to run GitHub Actions locally: $ACTION"

# Function to run specific workflow
run_workflow() {
    local workflow_file=$1
    local job_name=$2
    
    print_status "🚀 Running workflow: $workflow_file"
    
    act -q -j "$job_name" \
        -W "$workflow_file" \
        -P ubuntu-latest=catthehacker/ubuntu:act-latest \
        -s GITHUB_TOKEN=your-token-here
}

# Main execution
case "$ACTION" in
    "lint")
        print_status "🧹 Running LINT workflow..."
        run_workflow ".github/workflows/lint.yml" "quality"
        ;;
    "tests")
        print_status "🧪 Running TESTS workflow..."
        run_workflow ".github/workflows/laravel.yml" "laravel-tests"
        ;;
    "all")
        print_status "🚀 Running ALL workflows..."
        print_status "🧹 Running LINT workflow..."
        run_workflow ".github/workflows/lint.yml" "quality"
        
        print_status "🧪 Running TESTS workflow..."
        run_workflow ".github/workflows/laravel.yml" "laravel-tests"
        ;;
    "list")
        print_status "📋 Available workflows:"
        act -l
        ;;
    *)
        print_error "Unknown action: $ACTION"
        echo "Usage: $0 [lint|tests|all|list]"
        exit 1
        ;;
esac

print_success "🎊 Local GitHub Actions test completed!"

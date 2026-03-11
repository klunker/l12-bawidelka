#!/bin/bash

# Interactive scripts helper
# Usage: ./scripts-help.sh [script-name|category]

set -e

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

print_header() {
    echo -e "${CYAN}🚀 Available Scripts Helper${NC}"
    echo -e "${CYAN}==========================${NC}"
}

print_category() {
    echo -e "\n${YELLOW}📂 $1${NC}"
    echo -e "${YELLOW}$(printf '=%.0s' {1..20})${NC}"
}

print_script() {
    local script=$1
    local command=$2
    echo -e "${GREEN}•${NC} ${BLUE}$script${NC} → $command"
}

print_usage() {
    echo "Usage: $0 [script-name]"
    echo "       $0 [category]"
    echo ""
    echo "Categories: build, ci, dev, all"
    echo ""
    echo "Examples:"
    echo "  $0 build:simple"
    echo "  $0 build"
    echo "  $0 ci"
    echo "  $0 all"
}

# Parse package.json scripts using sed
parse_package_json() {
    local file="$1"
    
    # Extract scripts section and clean it up
    sed -n '/scripts/,/}/p' "$file" | \
        grep -v "scripts\|}" | \
        sed 's/^[[:space:]]*//' | \
        sed 's/,$//' | \
        sed 's/^"\([^"]*\)":\s*"\([^"]*\)"/\1|\2/'
}

# Check if package.json exists
if [[ ! -f "package.json" ]]; then
    echo "❌ package.json not found!"
    exit 1
fi

# Parse scripts from package.json
declare -A scripts
while IFS='|' read -r key value; do
    if [[ -n "$key" && -n "$value" ]]; then
        scripts["$key"]="$value"
    fi
done < <(parse_package_json package.json)

print_header

# Filter and display scripts
filter=${1:-"all"}

case "$filter" in
    "build")
        print_category "🏗️ Build Scripts"
        for key in "${!scripts[@]}"; do
            if [[ $key == build* ]]; then
                print_script "$key" "${scripts[$key]}"
            fi
        done
        ;;
    "ci")
        print_category "🧪 CI/Testing Scripts"
        for key in "${!scripts[@]}"; do
            if [[ $key == ci* || $key == act* ]]; then
                print_script "$key" "${scripts[$key]}"
            fi
        done
        ;;
    "dev")
        print_category "🛠️ Development Scripts"
        for key in "${!scripts[@]}"; do
            if [[ $key == dev* || $key == format* || $key == lint* || $key == types* || $key == help* ]]; then
                print_script "$key" "${scripts[$key]}"
            fi
        done
        ;;
    "all")
        print_category "🏗️ Build Scripts"
        for key in "${!scripts[@]}"; do
            if [[ $key == build* ]]; then
                print_script "$key" "${scripts[$key]}"
            fi
        done
        
        print_category "🧪 CI/Testing Scripts"
        for key in "${!scripts[@]}"; do
            if [[ $key == ci* || $key == act* ]]; then
                print_script "$key" "${scripts[$key]}"
            fi
        done
        
        print_category "🛠️ Development Scripts"
        for key in "${!scripts[@]}"; do
            if [[ $key == dev* || $key == format* || $key == lint* || $key == types* || $key == help* ]]; then
                print_script "$key" "${scripts[$key]}"
            fi
        done
        ;;
    *)
        # Check if it's a specific script
        if [[ -n "${scripts[$filter]}" ]]; then
            print_category "📋 Script Details"
            echo -e "${GREEN}🔧${NC} ${BLUE}$filter${NC}"
            echo -e "${GREEN}⚡${NC} ${scripts[$filter]}"
            echo ""
            echo -e "${YELLOW}▶️  Run with:${NC} ${CYAN}npm run $filter${NC}"
        else
            print_usage
            exit 1
        fi
        ;;
esac

echo ""
echo -e "${CYAN}💡 Tips:${NC}"
echo -e "  • Use ${YELLOW}./scripts-help.sh build${NC} to see build scripts only"
echo -e "  • Use ${YELLOW}./scripts-help.sh ci${NC} to see CI scripts only"
echo -e "  • Use ${YELLOW}./scripts-help.sh script-name${NC} for specific script details"

# 📁 Scripts Directory

This directory contains all custom utility scripts for the project.

## 🏗️ Build Scripts
- `build-simple.sh` - Simple build with UV_THREADPOOL_SIZE=1, RAYON_NUM_THREADS=1
- `build-with-git.sh` - Git-aware build (checks updates, pulls, then builds)

## 🧪 CI/Testing Scripts  
- `test-github-actions.sh` - Docker simulation of GitHub Actions workflows
- `run-act.sh` - Act tool runner for GitHub Actions

## 📋 Help Scripts
- `scripts-help.sh` - Interactive helper with colors
- `scripts-help-simple.sh` - Interactive helper without colors
- `scripts-docs.sh` - Documentation generator

## 🚀 Usage

All scripts are available via npm:
```bash
# Build scripts
npm run build:simple
npm run build:git

# CI testing
npm run ci:lint
npm run ci:tests
npm run ci:all
npm run act:lint
npm run act:tests
npm run act:all

# Help
npm run help
npm run help:simple
npm run help:build
npm run help:ci
npm run help:dev
```

## 🔧 Direct Execution

You can also run scripts directly:
```bash
./scripts/build-simple.sh
./scripts/scripts-help.sh
```

## 📝 Adding New Scripts

1. Create script in `scripts/` directory
2. Make it executable: `chmod +x scripts/your-script.sh`
3. Add to package.json scripts section
4. Update this README

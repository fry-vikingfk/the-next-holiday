# GitHub Actions CI/CD Setup

This project uses GitHub Actions for continuous integration.

## Workflows

### 1. Tests Workflow (`.github/workflows/tests.yml`)

**Triggers:**
- Every push to any branch
- Every pull request to `main`, `master`, or `develop`

**What it does:**
- ✅ Sets up PHP 8.4 with required extensions
- ✅ Installs Composer dependencies
- ✅ Configures PostgreSQL database
- ✅ Runs database migrations
- ✅ Executes the full test suite (90 tests)
- ✅ Uploads logs if tests fail

### 2. Code Quality Workflow (`.github/workflows/code-quality.yml`)

**Triggers:**
- Every push to any branch
- Every pull request to `main`, `master`, or `develop`

**What it does:**
- ✅ Runs Laravel Pint to check code style
- ✅ **Fails if code doesn't match style requirements**
- ❌ Does NOT auto-fix code

## How It Works

When you push code:

1. **Tests Workflow** - Runs all 90 tests (~1-2 min)
2. **Code Quality Workflow** - Checks code style (~30 sec)

Both must pass before merging PRs.

## Configuration

The tests workflow uses:
- PostgreSQL 16 database
- `APP_ENV=testing`
- Admin user created with default password

## Local Testing Before Push

**Always run these before pushing:**

```bash
# Run tests
make test

# Check code style
./vendor/bin/pint --test
```

If Pint reports issues, **manually fix them** in your code. The workflow will fail if style issues remain.

## Adding Status Badges

Add to README.md (replace `YOUR_USERNAME`):

```markdown
[![Tests](https://github.com/YOUR_USERNAME/the-next-holiday/actions/workflows/tests.yml/badge.svg)](https://github.com/YOUR_USERNAME/the-next-holiday/actions/workflows/tests.yml)
[![Code Quality](https://github.com/YOUR_USERNAME/the-next-holiday/actions/workflows/code-quality.yml/badge.svg)](https://github.com/YOUR_USERNAME/the-next-holiday/actions/workflows/code-quality.yml)
```

## Notes

- Code style violations must be fixed manually
- Workflows run on Ubuntu with PHP 8.4
- Test logs available as artifacts on failure

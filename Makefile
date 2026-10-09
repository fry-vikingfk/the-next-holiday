# sail commands
SAIL = vendor/bin/sail
ARTISAN = @$(SAIL) artisan

up:
	- @$(SAIL) up -d

down:
	- @$(SAIL) down

db-reset: up clear-cache
	- @$(SAIL) artisan migrate:fresh --seed

sail-artisan:
	- @$(ARTISAN)

composer-install:
	@if ! [ -x "$(command -v composer)" ]; then \
		echo "Composer not found. Installing Composer..."; \
		php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"; \
		php composer-setup.php --install-dir=/usr/local/bin --filename=composer; \
		php -r "unlink('composer-setup.php');"; \
	fi
	composer install

init: down db-reset test populate-holidays

install: composer-install init

npm:
	- npm run dev -d

clear-cache:
	- @$(SAIL) artisan cache:clear
	- @$(SAIL) artisan config:clear
	- @$(SAIL) artisan route:clear
	- @$(SAIL) artisan view:clear

test: clear-cache
	- @$(SAIL) artisan test --coverage

test-specific:
	- @$(SAIL) artisan test --filter=$(filter)

pint-test:
	- ./vendor/bin/pint --test

pint-fix:
	- ./vendor/bin/pint

# populate-holidays:
# 	- @$(SAIL) artisan holidays:populate $(shell date -d "$(shell date +%Y)-01-01" +%Y-%m-%d) $(shell date -d "$(shell date +%Y)-12-31" +%Y-%m-%d)

# Full quality check: Fix code style and run tests
check:
	@echo "========================================"
	@echo "Running full quality check..."
	@echo "========================================"
	@echo ""
	@echo "Step 1/2: Fixing code style with Pint..."
	@$(SAIL) exec laravel.test vendor/bin/pint
	@echo ""
	@echo "✓ Code style fixed!"
	@echo ""
	@echo "Step 2/2: Running tests..."
	@$(ARTISAN) test
	@echo ""
	@echo "========================================"
	@echo "✓ All checks passed!"
	@echo "========================================"
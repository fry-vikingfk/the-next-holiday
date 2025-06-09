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

test:
	- @$(SAIL) artisan test

# populate-holidays:
# 	- @$(SAIL) artisan holidays:populate $(shell date -d "$(shell date +%Y)-01-01" +%Y-%m-%d) $(shell date -d "$(shell date +%Y)-12-31" +%Y-%m-%d)
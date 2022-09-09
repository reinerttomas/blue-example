APP := blue-example-app

### DOCKER ###

build:
	@docker compose build

up:
	@docker compose up -d

down:
	@docker compose down

clean:
	@docker system prune --all --force

app:
	@docker exec -it $(APP) bash

### ANALYSIS ###

phpstan:
	@docker exec -e APP_ENV=test -it $(APP) composer phpstan

ccs:
	@docker exec -e PHP_ENV=test -it $(APP) composer ccs

fcs:
	@docker exec -e PHP_ENV=test -it $(APP) composer fcs

ci:
	@docker exec -e APP_ENV=test -it $(APP) composer ci

### DATA FIXTURES ###
fixtures:
	@docker exec -e PHP_ENV=test -it $(APP) php bin/console doctrine:fixtures:load -n
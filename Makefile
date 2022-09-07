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
	@docker exec -e PHP_ENV=test -it $(APP) composer phpstan

ccs:
	@docker exec -e PHP_ENV=test -it $(APP) composer ccs

fcs:
	@docker exec -e PHP_ENV=test -it $(APP) composer fcs

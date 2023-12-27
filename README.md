## BtcBit Transposition task

## Installation

```
docker run --rm --interactive --tty \
--volume $PWD:/app \
composer install
```

## Usage

```
docker run -it --rm --volume $PWD:/app php:8.3-cli bash
php /app/index.php -3 < /app/tests/data/test1.json
php /app/index.php -1 < /app/tests/data/test2.json
php /app/index.php 1 < /app/tests/data/test3.json
```

## Tests

```
docker run --rm --interactive --tty \
--volume $PWD:/app \
php:8.3-cli ./app/vendor/bin/phpunit app/tests
```
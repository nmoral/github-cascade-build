
install:
	docker run -d --name symfony ghcr.io/nmoral/docker-symfony:6.0-php-8.1-dev
	docker cp symfony:/application application
	cp -r application/* .
	docker stop symfony
	docker rm symfony
	rm -rf application

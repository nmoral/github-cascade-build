
install:
	docker run -d --name symfony ghcr.io/nmoral/symfony
	docker cp symfony:/application tmp
	cp -r tmp/* .
	docker stop symfony
	docker rm symfony
	rm -rf tmp

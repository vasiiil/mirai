FROM mysql:8 as builder
RUN ["sed", "-i", "s/exec \"$@\"/echo \"not running $@\"/", "/usr/local/bin/docker-entrypoint.sh"]

ENV MYSQL_DATABASE=test_db
ENV MYSQL_ROOT_PASSWORD=root
COPY city.sql /docker-entrypoint-initdb.d/city.sql
COPY my.cnf /etc/my.cnf

RUN ["/usr/local/bin/docker-entrypoint.sh", "mysqld", "--datadir", "/initialized-db", "--default-authentication-plugin", "mysql_native_password"]

FROM mysql:8
COPY --from=builder /initialized-db /var/lib/mysql

FROM drupalci/db-base

# Packages.
RUN apt-get -y install mysql-server netcat

RUN apt-get clean
RUN apt-get autoclean
RUN apt-get -y autoremove

RUN sed -i -e"s/^bind-address\s*=\s*127.0.0.1/bind-address = 0.0.0.0/" /etc/mysql/my.cnf
RUN rm -rf /var/lib/mysql/*

USER root
EXPOSE 3306

ADD ./conf/startup.sh /opt/startup.sh

CMD ["/bin/bash", "/opt/startup.sh"]

FROM jenkins/jenkins:latest
ENV JAVA_OPTS -Dcasc.jenkins.config=/var/jenkins_home/casc_configs
COPY jenkins.yaml /var/jenkins_home/casc_configs/jenkins.yaml
USER root
RUN apt-get update && apt-get install -y lsb-release
RUN curl -fsSLo /usr/share/keyrings/docker-archive-keyring.asc \
  https://download.docker.com/linux/debian/gpg
RUN echo "deb [arch=$(dpkg --print-architecture) \
  signed-by=/usr/share/keyrings/docker-archive-keyring.asc] \
  https://download.docker.com/linux/debian \
  $(lsb_release -cs) stable" > /etc/apt/sources.list.d/docker.list
RUN apt-get update && apt-get install -y docker-ce-cli
RUN apt-get install -y php php-mbstring php-xml php-bcmath php-mysqli && apt-get install -y composer
USER jenkins
RUN jenkins-plugin-cli --plugins "blueocean docker-workflow sonar configuration-as-code"
RUN echo "sonar.host.url=http://sonarqube:9000" >> /var/jenkins_home/sonar-scanner.properties



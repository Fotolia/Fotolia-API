SRC	= org/webservice/fotolia/FotoliaApi.java org/webservice/fotolia/FotoliaApiResponse.java \
	org/webservice/fotolia/FotoliaApiException.java org/webservice/fotolia/FotoliaApiArgs.java \
	org/webservice/fotolia/FotoliaSubAccountData.java org/webservice/fotolia/FotoliaSearchQuery.java \
	org/webservice/fotolia/FotoliaCreateMemberQuery.java

all: build jar

build: ${SRC}
	javac -classpath 'libs/httpcomponents-client-4.1.2/lib/*:/usr/share/java/*' ${SRC}

jar: 
	jar cf fotolia-api.jar org/webservice/fotolia

clean:
	rm -f ${SRC:.java=.class} fotolia-api.jar example.class

example:
	javac -classpath 'libs/httpcomponents-client-4.1.2/lib/*:/usr/share/java/*:.' example.java

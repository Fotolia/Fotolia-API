package org.webservice.fotolia;

import java.io.IOException;
import java.util.Properties;

import static org.junit.Assert.assertNotNull;
import static org.junit.Assert.assertTrue;

/**
 * Base class for All test cases.
 */
public abstract class BaseTest {

    protected static String API_KEY;
    protected static String FOTOLIA_API_LOGIN_NAME;
    protected static String FOTOLIA_API_PASSWORD;
    protected static String name = "config.properties"; // file with config properties

    protected BaseTest() {
        Properties prop = new Properties();
        try {
            prop.load(getClass().getResourceAsStream(name)); // read from the same folder as original class file
        } catch (IOException e) {
            System.out.println(name + "config file was not found! Build 'test/resources' folder content too!");
            e.printStackTrace();
        }

        API_KEY = prop.getProperty("FOTOLIA_API_KEY");
//        System.out.println("FOTOLIA_API_KEY = " + API_KEY);

        FOTOLIA_API_LOGIN_NAME = prop.getProperty("FOTOLIA_API_LOGIN_NAME");
//        System.out.println("FOTOLIA_API_LOGIN_NAME = " + FOTOLIA_API_LOGIN_NAME);

        FOTOLIA_API_PASSWORD = prop.getProperty("FOTOLIA_API_PASSWORD");
//        System.out.println("FOTOLIA_API_PASSWORD = " + FOTOLIA_API_PASSWORD);

        if (API_KEY == null || API_KEY.isEmpty() || API_KEY.equals("${fotolia.api.key}")
                || FOTOLIA_API_LOGIN_NAME == null || FOTOLIA_API_LOGIN_NAME.isEmpty() || FOTOLIA_API_LOGIN_NAME.equals("${fotolia.api.login.name}")
                || FOTOLIA_API_PASSWORD == null || FOTOLIA_API_PASSWORD.isEmpty() || FOTOLIA_API_PASSWORD.equals("${fotolia.api.password}")) {

            System.out.println("**********************************************");
            System.out.println(" ARE YOU TRYING TO RUN UNIT TESTS from JAVA IDE ???");
            System.out.println(" If so, please change 'test/resources/org/webservice/fotolia/config.properties'" +
                    "\n content manually and BUILD it again!!");
            System.out.println("**********************************************");
            System.out.println("\n ARE YOU RUNNING UNIT TESTS by MAVEN ???");
            System.out.println(" If so, please create config file 'settings.xml'" +
                    "\n by using supplied 'settings_example.xml'" +
                    "\n and put in into MAVEN REPOSITORY folder !!");
            System.out.println(" See MAVEN installation instructions - http://maven.apache.org/download.html#Installation");
            System.out.println(" See MAVEN 'settings' instructions - http://maven.apache.org/settings.html#Quick_Overview");
            System.out.println("**********************************************");
            throw new RuntimeException("Error running UNIT TESTS from IDE !!");
        }
        // last check, if something completely wrong
        assertNotNull(API_KEY);
        assertTrue(!API_KEY.startsWith("${"));
        assertNotNull(FOTOLIA_API_LOGIN_NAME);
        assertTrue(!FOTOLIA_API_LOGIN_NAME.startsWith("${"));
        assertNotNull(FOTOLIA_API_PASSWORD);
        assertTrue(!FOTOLIA_API_PASSWORD.startsWith("${"));

    }
}

package org.webservice.fotolia;

import org.junit.Before;
import org.junit.Test;

import static org.junit.Assert.assertNotNull;
import static org.junit.Assert.assertTrue;

/**
 * Unit test for API test call.
 */
public class LoginTest extends BaseTest {

    private FotoliaApi client;

    @Before
    public void setUp() throws Exception {
        client = new FotoliaApi(API_KEY);
    }

    @Test
    public void test_correctLogin() {
        assertNotNull(client);
        client.loginUser(FOTOLIA_API_LOGIN_NAME, FOTOLIA_API_PASSWORD);
        client.logoutUser();
    }

    @Test
    public void test_correctLoginHttps() {
        assertNotNull(client);
        client.setHttpsMode(true);
        client.loginUser(FOTOLIA_API_LOGIN_NAME, FOTOLIA_API_PASSWORD);
        client.logoutUser();
    }

    @Test(expected = NullPointerException.class)
    public void test_incorrectLogin() throws Exception {
        assertNotNull(client);
        client.loginUser("dummy_test_name", "dummy_test_password");
    }

    @Test(expected = NullPointerException.class)
    public void test_incorrectLoginHttps() throws Exception {
        assertNotNull(client);
        client.setHttpsMode(true);
        client.loginUser("dummy_test_name", "dummy_test_password");
    }
}

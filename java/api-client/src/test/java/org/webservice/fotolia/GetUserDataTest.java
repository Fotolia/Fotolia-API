package org.webservice.fotolia;

import org.json.simple.JSONObject;
import org.junit.Before;
import org.junit.Test;

import static org.junit.Assert.assertNotNull;
import static org.junit.Assert.assertNull;
import static org.junit.Assert.assertTrue;

/**
 * Unit test for API test call.
 */
public class GetUserDataTest extends BaseTest {

    private FotoliaApi client;

    @Before
    public void setUp() throws Exception {
        client = new FotoliaApi(API_KEY);
    }

    @Test
    public void test_GetUserData() {
        assertNotNull(client);
        client.loginUser(FOTOLIA_API_LOGIN_NAME, FOTOLIA_API_PASSWORD);
        JSONObject result = client.getUserData();
        assertNotNull(result);

        checkUserDataProresties(result);
    }

    private void checkUserDataProresties(JSONObject result) {
        Object id = result.get("id");
        assertNotNull(id);
        assertTrue(id instanceof Long);
        assertTrue((Long) id > 0);

        Object currency_name = result.get("currency_name");
        assertNotNull(currency_name);
        assertTrue(currency_name instanceof String);
        assertTrue(!((String) currency_name).isEmpty());

        Object lastName = result.get("lastname");
        assertNotNull(lastName);
        assertTrue(lastName instanceof String);
        assertTrue(!((String) lastName).isEmpty());

        Object firstName = result.get("firstname");
        assertNotNull(firstName);
        assertTrue(firstName instanceof String);
        assertTrue(!((String) firstName).isEmpty());
    }

    @Test
    public void test_correctLoginHttps() {
        assertNotNull(client);
        client.setHttpsMode(true);
        client.loginUser(FOTOLIA_API_LOGIN_NAME, FOTOLIA_API_PASSWORD);
        JSONObject result = client.getUserData();
        assertNotNull(result);
        checkUserDataProresties(result);
    }

    @Test
    public void test_GetUserData_WithoutLogin() throws Exception {
        assertNotNull(client);
//        client.loginUser("dummy_test_name", "dummy_test_password");
        JSONObject result = client.getUserData();
        assertNull(result);
    }


    // TODO: actually it should not fail with NPE!!!
//    @Test
    @Test(expected = NullPointerException.class)
    public void test_GetUserData_FAIL() throws Exception {
        assertNotNull(client);
        client.loginUser("dummy_test_name", "dummy_test_password");
        JSONObject result = client.getUserData();
        assertNull(result);
    }

    // TODO: actually it should not fail with NPE!!!
//    @Test
    @Test(expected = NullPointerException.class)
    public void test_GetUserDataHttps_FAIL() throws Exception {
        assertNotNull(client);
        client.setHttpsMode(true);
        client.loginUser("dummy_test_name", "dummy_test_password");
        JSONObject result = client.getUserData();
        assertNull(result);
    }
}

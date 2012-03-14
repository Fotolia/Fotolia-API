package org.webservice.fotolia;

import org.junit.*;

import static org.junit.Assert.*;

/**
 * Unit test for API test call.
 */
public class TestCallTest extends BaseTest {

    private FotoliaApi client;

    @Before
    public void setUp() throws Exception {
        assertNotNull(API_KEY);
        client = new FotoliaApi(API_KEY);
    }

    @Test
    public void test_testCall() {
        boolean result = client.test();
        assertTrue(result);
    }

    @Test
    public void test_testCallHttps() throws Exception {
        client = new FotoliaApi(API_KEY, true);
        boolean result = client.test();
        assertTrue(result);
    }
}

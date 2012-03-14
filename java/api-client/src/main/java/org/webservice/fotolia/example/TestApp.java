package org.webservice.fotolia.example;

import org.webservice.fotolia.*;
import org.json.simple.JSONObject;

public class TestApp
{
    public static void main(String[] args)
    {
        FotoliaApi client = new FotoliaApi("your_api_key");

        // fetching a media data
        System.out.println(client.getMediaData(18136053));

        // searching files
        FotoliaSearchQuery query = new FotoliaSearchQuery();
        query.setWords("car").setLanguageId(FotoliaApi.LANGUAGE_ID_EN_US).setLimit(1);
        System.out.println(client.getSearchResults(query));

        // buying and downloading a file
        try {
            client.loginUser("your_login", "your_password");
            JSONObject res = client.getMedia(35957426, "XS");
            client.downloadMedia((String) res.get("url"), "/tmp/" + (String) res.get("name"));
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}

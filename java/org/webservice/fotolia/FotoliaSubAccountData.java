package org.webservice.fotolia;

import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;

import org.apache.http.message.BasicNameValuePair;

public class FotoliaSubAccountData extends HashMap<String, String>
{
    /**
     * Constructor
     *
     * @param  firstname
     * @param  lastname
     * @param  email
     * @param  company
     */
    public FotoliaSubAccountData(final String firstname, final String lastname, final String email, final String company)
    {
        this.setFirstName(firstname).setLastName(lastname).setEmail(email).setCompany(company);
    }

    /**
     * Sets the firstname of the subaccount
     *
     * @param  firstname
     * @return FotoliaSubAccountData
     */
    public FotoliaSubAccountData setFirstName(final String firstname)
    {
        this.put("firstname", firstname);
        return this;
    }

    /**
      * Returns the firstname of the subaccount
      *
      * @return String
      */
    public String getFirstName()
    {
        return this.get("firstname");
    }

    /**
     * Sets the lastname of the subaccount
     *
     * @param  lastname
     * @return FotoliaSubAccountData
     */
    public FotoliaSubAccountData setLastName(final String lastname)
    {
        this.put("lastname", lastname);
        return this;
    }

    /**
      * Returns the lastname of the subaccount
      *
      * @return String
      */
    public String getLastName()
    {
        return this.get("lastname");
    }

    /**
     * Sets the email of the subaccount
     *
     * @param  email
     * @return FotoliaSubAccountData
     */
    public FotoliaSubAccountData setEmail(final String email)
    {
        this.put("email", email);
        return this;
    }

    /**
      * Returns the email of the subaccount
      *
      * @return String
      */
    public String getEmail()
    {
        return this.get("email");
    }

    /**
     * Sets the company of the subaccount
     *
     * @param  company
     * @return FotoliaSubAccountData
     */
    public FotoliaSubAccountData setCompany(final String company)
    {
        this.put("company", company);
        return this;
    }

    /**
      * Returns the company of the subaccount
      *
      * @return String
      */
    public String getCompany()
    {
        return this.get("company");
    }

    /**
     * Returns a Fotolia API args from this class
     *
     * @return FotoliaApiArgs
     */
    public FotoliaApiArgs getFotoliaApiArgs()
    {
        FotoliaApiArgs args;
        Iterator iter;
        Map.Entry entry;

        args = new FotoliaApiArgs();
        iter = this.entrySet().iterator();
        while (iter.hasNext()) {
            entry = (Map.Entry) iter.next();

            args.add(new BasicNameValuePair("subaccount_data[" + (String) entry.getKey() + "]", (String) entry.getValue()));
        }

        return args;
    }
}

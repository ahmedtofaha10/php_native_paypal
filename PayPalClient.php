<?php


use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

class PayPalClient
{
    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }

    /**
     * Set up and return PayPal PHP SDK environment with PayPal access credentials.
     * This sample uses SandboxEnvironment. In production, use LiveEnvironment.
     */
    public static function environment()
    {
        $clientId = getenv("CLIENT_ID") ?: "AbN6y_beCReR3ajcofRdNyiVHBGLY8Gkh96LiJBSV_UeTze26IMK3SNN5XFWbz15xT_bXRhC6QxRn1dk";
        $clientSecret = getenv("CLIENT_SECRET") ?: "EELqg_EDfGTi5htBpX7MRgMfw72gZ8EozZJYVD8DI0fIKFA4AWHgm0n_Q4kofnIQJlJB_iDTZMzDqUFp";
        return new SandboxEnvironment($clientId, $clientSecret);
    }
}
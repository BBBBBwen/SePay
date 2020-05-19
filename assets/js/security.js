    var password = document.getElementById('password');
    var confirmed_password = document.getElementById('confirmed_password');
    var submit = document.getElementById('submit');

    function hash() {
        password = document.getElementById('password').value;

        if (password.length != 0) {
            var hash = SHA256.hash(password);
            document.getElementById("password").value = hash;
        }

        confirmed_password = document.getElementById('confirmed_password').value;
        if (confirmed_password.length != 0) {
            var confirmed_hash = SHA256.hash(confirmed_password);
            document.getElementById("confirmed_password").value = confirmed_hash;
        }
    }

    function CheckPassword() {
        if (password.value.length < 6) {
            submit.disabled = true;
            submit.value = 'Please enter at least 6 characters password';
        } else {
            submit.disabled = false;
            submit.value = 'Register';
        }
    }

    //Encrypt payment password(DES) by RSA
    function encryption() {
        var DES_key = document.getElementById("payment_password").value;
        if (DES_key.length != 0) {
            var encrypted_des_key = RSA_encryption(DES_key);
            document.getElementById("payment_password").value = encrypted_des_key;
        }
    }

    //Encrypt DES key by RSA public key
    function RSA_encryption(deskey) {
        var pubilc_key = "-----BEGIN PUBLIC KEY-----MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzdxaei6bt/xIAhYsdFdW62CGTpRX+GXoZkzqvbf5oOxw4wKENjFX7LsqZXxdFfoRxEwH90zZHLHgsNFzXe3JqiRabIDcNZmKS2F0A7+Mwrx6K2fZ5b7E2fSLFbC7FsvL22mN0KNAp35tdADpl4lKqNFuF7NT22ZBp/X3ncod8cDvMb9tl0hiQ1hJv0H8My/31w+F+Cdat/9Ja5d1ztOOYIx1mZ2FD2m2M33/BgGY/BusUKqSk9W91Eh99+tHS5oTvE8CI8g7pvhQteqmVgBbJOa73eQhZfOQJ0aWQ5m2i0NUPcmwvGDzURXTKW+72UKDz671bE7YAch2H+U7UQeawwIDAQAB-----END PUBLIC KEY-----";
        var encrypt = new JSEncrypt();
        encrypt.setPublicKey(pubilc_key);
        var encrypted = encrypt.encrypt(deskey);
        return encrypted;
    }

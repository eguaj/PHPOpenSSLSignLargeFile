# PHPOpenSSLSignLargeFile

Alternative to openssl\_sign() and openssl\_verify() with support for large
files.

The default openssl\_sign() and openssl\_verify() functions work with in memory
data, which is not suitable for signing large files that might not fit entirely
in memory.

The PHPOpenSSLSignLargeFile provides alternative and compatible functions for
signing large files that do not fit in memory.

# Usage

    bool openssl_sign_large_file(string $pathToFile, string &$signature, mixed $priv_key_id)
    bool openssl_verify_large_file(string $pathToFile, string $signature, mixed $pub_key_id)

`signature_alg` is hardcoded as `OPENSSL_ALGO_SHA1`.


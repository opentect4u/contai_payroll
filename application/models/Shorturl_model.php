<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Self-hosted URL shortener.
 *
 * Destination URLs are stored encrypted (AES + HMAC-SHA512 authentication via
 * CodeIgniter's Encryption library), so a tampered or forged payload fails to
 * decrypt rather than silently resolving. Short codes are random and carry no
 * information about the record they point to. Links auto-expire: resolve()
 * only matches rows whose expires_at is still in the future.
 */
class Shorturl_model extends CI_Model
{
    private $code_length = 10;
    private $code_alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('encryption');
    }

    /**
     * Create a short-lived, encrypted short URL for $long_url.
     *
     * @param string $long_url
     * @param int    $ttl_days  Link lifetime in days (default 2).
     * @return string|false     The short URL, or false on failure.
     */
    public function create($long_url, $ttl_days = 2)
    {
        if (!filter_var($long_url, FILTER_VALIDATE_URL)) {
            return false;
        }

        $this->_cleanup_expired();

        $encrypted = $this->encryption->encrypt($long_url);
        if ($encrypted === false) {
            return false;
        }

        $expires_at = date('Y-m-d H:i:s', strtotime('+' . (int) $ttl_days . ' days'));

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $code = $this->_generate_code();

            $this->db->where('short_code', $code);
            if ($this->db->count_all_results('td_short_urls') > 0) {
                continue; // collision, try another code
            }

            $inserted = $this->db->insert('td_short_urls', array(
                'short_code' => $code,
                'payload'    => $encrypted,
                'expires_at' => $expires_at,
            ));

            return $inserted ? site_url('s/' . $code) : false;
        }

        return false;
    }

    /**
     * Resolve a short code back to its original URL.
     *
     * Returns false if the code is unknown, expired, or the stored payload
     * fails HMAC verification (tampered).
     *
     * @param string $code
     * @return string|false
     */
    public function resolve($code)
    {
        $this->db->where('short_code', $code);
        $this->db->where('expires_at >', date('Y-m-d H:i:s'));
        $row = $this->db->get('td_short_urls')->row();

        if (!$row) {
            return false;
        }

        $long_url = $this->encryption->decrypt($row->payload);
        if ($long_url === false) {
            return false;
        }

        $this->db->where('id', $row->id);
        $this->db->set('access_count', 'access_count+1', false);
        $this->db->update('td_short_urls');

        return $long_url;
    }

    private function _generate_code()
    {
        $code = '';
        $max = strlen($this->code_alphabet) - 1;
        for ($i = 0; $i < $this->code_length; $i++) {
            $code .= $this->code_alphabet[random_int(0, $max)];
        }
        return $code;
    }

    /**
     * Opportunistically clear out expired rows instead of requiring a cron job.
     */
    private function _cleanup_expired()
    {
        if (random_int(1, 20) === 1) {
            $this->db->where('expires_at <', date('Y-m-d H:i:s'));
            $this->db->delete('td_short_urls');
        }
    }
}

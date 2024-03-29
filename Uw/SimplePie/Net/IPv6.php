<?php

/**
 * Class to validate and to work with IPv6 addresses.
 *
 * @package SimplePie
 * @copyright 2003-2005 The PHP Group
 * @license http://www.opensource.org/licenses/bsd-license.php
 * @link http://pear.php.net/package/Net_IPv6
 * @author Alexander Merz <alexander.merz@web.de>
 * @author elfrink at introweb dot nl
 * @author Josh Peck <jmp at joshpeck dot org>
 * @author Geoffrey Sneddon <geoffers@gmail.com>
 */
class SimplePie_Net_IPv6
{

    /**
     * Removes a possible existing netmask specification of an IP address.
     *
     * @param string $ip the (compressed) IP as Hex representation
     * @return string the IP the without netmask
     * @since 1.1.0
     * @access public
     * @static
     */
    function removeNetmaskSpec($ip)
    {
        if (strpos($ip, '/') !== false) {
            list($addr, $nm) = explode('/', $ip);
        } else {
            $addr = $ip;
        }
        return $addr;

    }

    /**
     * Uncompresses an IPv6 address
     *
     * RFC 2373 allows you to compress zeros in an address to '::'. This
     * function expects an valid IPv6 address and expands the '::' to
     * the required zeros.
     *
     * Example:	 FF01::101	->	FF01:0:0:0:0:0:0:101
     * 			 ::1		->	0:0:0:0:0:0:0:1
     *
     * @access public
     * @static
     * @param string $ip a valid IPv6-address (hex format)
     * @return string the uncompressed IPv6-address (hex format)
     */
    function Uncompress($ip)
    {
        $uip = SimplePie_Net_IPv6::removeNetmaskSpec($ip);
        $c1 = -1;
        $c2 = -1;
        if (strpos($ip, '::') !== false) {
            list($ip1, $ip2) = explode('::', $ip);
            if ($ip1 === '') {
                $c1 = -1;
            } else {
                $pos = 0;
                if (($pos = substr_count($ip1, ':')) > 0) {
                    $c1 = $pos;
                } else {
                    $c1 = 0;
                }
            }
            if ($ip2 === '') {
                $c2 = -1;
            } else {
                $pos = 0;
                if (($pos = substr_count($ip2, ':')) > 0) {
                    $c2 = $pos;
                } else {
                    $c2 = 0;
                }
            }
            if (strstr($ip2, '.')) {
                $c2++;
            }
            // ::
            if ($c1 === -1 && $c2 === -1) {
                $uip = '0:0:0:0:0:0:0:0';
            }
            // ::xxx
            else if ($c1 === -1) {
                $fill = str_repeat('0:', 7 - $c2);
                $uip = str_replace('::', $fill, $uip);
            }
            // xxx::
            else if ($c2 === -1) {
                $fill = str_repeat(':0', 7 - $c1);
                $uip = str_replace('::', $fill, $uip);
            }
            // xxx::xxx
            else {
                $fill = str_repeat(':0:', 6 - $c2 - $c1);
                $uip = str_replace('::', $fill, $uip);
                $uip = str_replace('::', ':', $uip);
            }
        }
        return $uip;

    }

    /**
     * Splits an IPv6 address into the IPv6 and a possible IPv4 part
     *
     * RFC 2373 allows you to note the last two parts of an IPv6 address as
     * an IPv4 compatible address
     *
     * Example:	 0:0:0:0:0:0:13.1.68.3
     * 			 0:0:0:0:0:FFFF:129.144.52.38
     *
     * @access public
     * @static
     * @param string $ip a valid IPv6-address (hex format)
     * @return array [0] contains the IPv6 part, [1] the IPv4 part (hex format)
     */
    function SplitV64($ip)
    {
        $ip = SimplePie_Net_IPv6::Uncompress($ip);
        if (strstr($ip, '.')) {
            $pos = strrpos($ip, ':');
            $ip[$pos] = '_';
            $ipPart = explode('_', $ip);
            return $ipPart;
        } else {
            return array($ip, '');
        }

    }

    /**
     * Checks an IPv6 address
     *
     * Checks if the given IP is IPv6-compatible
     *
     * @access public
     * @static
     * @param string $ip a valid IPv6-address
     * @return bool true if $ip is an IPv6 address
     */
    function checkIPv6($ip)
    {
        $ipPart = SimplePie_Net_IPv6::SplitV64($ip);
        $count = 0;
        if (!empty($ipPart[0])) {
            $ipv6 = explode(':', $ipPart[0]);
            for ($i = 0; $i < count($ipv6); $i++) {
                $dec = hexdec($ipv6[$i]);
                $hex = strtoupper(preg_replace('/^[0]{1,3}(.*[0-9a-fA-F])$/', '\\1', $ipv6[$i]));
                if ($ipv6[$i] >= 0 && $dec <= 65535 && $hex === strtoupper(dechex($dec))) {
                    $count++;
                }
            }
            if ($count === 8) {
                return true;
            } elseif ($count === 6 && !empty($ipPart[1])) {
                $ipv4 = explode('.', $ipPart[1]);
                $count = 0;
                foreach ($ipv4 as $ipv4_part) {
                    if ($ipv4_part >= 0 && $ipv4_part <= 255 && preg_match('/^\d{1,3}$/', $ipv4_part)) {
                        $count++;
                    }
                }
                if ($count === 4) {
                    return true;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

}

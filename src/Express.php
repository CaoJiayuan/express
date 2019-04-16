<?php
/**
 * @author caojiayuan
 */

namespace Nerio\Express;


interface Express
{
    public function query($deliverNo, $code = null);
}
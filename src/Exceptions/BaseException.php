<?php

/**
 * Copyright (c) D3 Data Development (Inh. Thomas Dartsch)
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * https://www.d3data.de
 *
 * @copyright (C) D3 Data Development (Inh. Thomas Dartsch)
 * @author    D3 Data Development - Daniel Seifert <info@shopmodule.com>
 * @link      https://www.oxidmodule.com
 */

declare(strict_types=1);

namespace D3\KlicktippPhpClient\Exceptions;

use Exception;

class BaseException extends Exception implements KlicktippExceptionInterface
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        $message = 'Klicktipp error: '.$message;
        parent::__construct($message, $code, $previous);
    }
}

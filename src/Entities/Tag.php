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

namespace D3\KlicktippPhpClient\Entities;

use Doctrine\Common\Collections\ArrayCollection;

class Tag extends ArrayCollection
{
    public function getId(): string
    {
        return $this->get('tagid');
    }

    public function getName(): string
    {
        return $this->get('name');
    }

    public function getText(): string
    {
        return $this->get('text');
    }
}

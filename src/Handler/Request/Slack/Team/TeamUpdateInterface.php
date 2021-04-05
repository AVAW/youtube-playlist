<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Team;

interface TeamUpdateInterface
{

    public function getName(): ?string;

    public function getEmailDomain(): ?string;

    public function getIconUrl(): ?string;

}

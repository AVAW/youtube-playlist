<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Action;

interface ActionCollectionCreateInterface
{

    public function getType(): string;

    public function getToken(): string;

    public function getTriggerId(): string;

    public function getEnterprise(): ?string;

    public function isEnterpriseInstall(): bool;

    public function getResponseUrl(): string;

    public function getActions(): array;

}

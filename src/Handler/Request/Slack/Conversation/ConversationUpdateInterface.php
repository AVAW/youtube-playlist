<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Conversation;

interface ConversationUpdateInterface
{

    public function getName(): ?string;

    public function getTeams(): array;

    public function getCreatorId(): ?string;

    public function getIsArchived(): ?bool;

    public function getIsChannel(): ?bool;

    public function getIsExtShared(): ?bool;

    public function getIsFrozen(): ?bool;

    public function getIsGeneral(): ?bool;

    public function getIsGlobalShared(): ?bool;

    public function getIsGroup(): ?bool;

    public function getIsIm(): ?bool;

    public function getIsMoved(): ?bool;

    public function getIsMpim(): ?bool;

    public function getIsNonThreadable(): ?bool;

    public function getIsOpen(): ?bool;

    public function getIsOrgDefault(): ?bool;

    public function getIsPrivate(): ?bool;

    public function getIsShared(): ?bool;

    public function getPurpose(): ?string;

    public function getTopic(): ?string;

}

<?php

namespace Ronssij\FilamentSimpleDraft\Contracts;

interface CanBePublished
{
    public function getQualifiedPublishedColumn(): string;
}

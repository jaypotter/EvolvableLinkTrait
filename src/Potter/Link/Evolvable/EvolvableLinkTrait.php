<?php

declare(strict_types=1);

namespace Potter\Link\Evolvable;

use \Potter\Cloneable\CloneableInterface;

trait EvolvableLinkTrait 
{
    final public function withHref(Stringable|string $href): static
    {
        $this->with('href', (string) $href);
    }
    
    final public function withRel(string $rel): static
    {
        $rels = $this->getRels();
        $clone = $this->getClone();
        if (in_array($rel, $rels)) {
            return $clone;
        }
        array_push($rels, $rel);
        $clone->setRels($rels);
        return $clone;
    }
    
    final public function withoutRel(string $rel): static
    {
        $rels = $this->getRels();
        $clone = $this->getClone();
        if (!in_array($rel, $rels)) {
            return $clone;
        }
        $rels = array_diff($rels, [$rel]);
        $clone->setRels($rels);
        return $clone;
    }
    
    final public function withAttribute(string $attribute, string $value): static
    {
        $attributes = $this->getAttributes();
        $clone = $this->getClone();
        $attributes[$attribute] = $value;
        $clone->setAttributes($attributes);
        return $clone;
    }
    
    final public function withoutAttribute(string $attribute): static
    {
        $attributes = $this->getAttributes();
        $clone = $this->getClone();
        $attributes = array_diff($attributes, [$attribute]);
        $clone->setAttributes($attributes);
        return $clone;
    }
    
    abstract public function getClone(): CloneableInterface;
    abstract protected function with(string $id, mixed $entry): CloneableInterface;
    abstract protected function without(string $id): CloneableInterface;
    
    abstract public function getRels(): array;
    abstract public function hasRel(string $rel): bool;
    abstract protected function setRels(array $rels): void;
    abstract public function getAttributes(): array;
    abstract public function hasAttribute(string $key): bool;
    abstract protected function setAttributes(array $attributes): void;
}
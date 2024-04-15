<?php

namespace MagisSolutions\FilamentTreeSelect;

use Filament\Forms\Components\Field;
use Illuminate\Support\Arr;

class TreeSelect extends Field
{
    protected string $view = 'filament-tree-select::tree-select';

    protected string $relationship;

    protected string $labelAttribute;

    protected function setUp(): void
    {
        $this->formatStateUsing(function (self $component) {
            return $component->getRecord()?->{$component->name}()->get()->toArray() ?: [];
        });

        $this->saveRelationshipsUsing(static function (self $component, $state) {
            $component->getRecord()->{$component->name}()->sync(Arr::pluck($state, 'id'));
        });
    }

    public function getLabelAttribute()
    {
        return $this->labelAttribute;
    }

    public function options()
    {
        $recordModel = new ($this->getModel());
        $relationship = $recordModel?->{$this->relationship}()
            ->getModel()
            ->whereNull('parent_id')
            ->with('children.children.children.children')
            ->get();

        return $relationship->toArray();
    }

    public function searchItems()
    {
        $recordModel = new ($this->getModel());
        $relationship = $recordModel?->{$this->relationship}()
            ->getModel()
            ->with('parent.parent.parent.parent')
            ->get()
            ->map(function ($item) {
                if ($item->parent) {
                    $breadcrumbs = collect([$item->parent->name]);
                    $current = $item->parent;

                    while ($current->parent) {
                        $breadcrumbs->prepend($current->parent->name);
                        $current = $current->parent;
                    }

                    $item['breadcrumbs'] = $breadcrumbs->join(' > ');
                }

                return $item;
            });

        return $relationship->toArray();
    }

    public function relationship(string $name, string $labelAttribute)
    {
        $this->relationship = $name;
        $this->labelAttribute = $labelAttribute;

        return $this;
    }
}

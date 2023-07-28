<?php

namespace LaravelEnso\Addresses\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Addresses\Services\Coordinates;
use LaravelEnso\Companies\Models\Company;
use LaravelEnso\Countries\Models\Country;
use LaravelEnso\DynamicMethods\Traits\Abilities;
use LaravelEnso\Helpers\Traits\AvoidsDeletionConflicts;
use LaravelEnso\Helpers\Traits\UpdatesOnTouch;
use LaravelEnso\People\Models\Person;
use LaravelEnso\Rememberable\Traits\Rememberable;
use LaravelEnso\TrackWho\Traits\CreatedBy;

class Address extends Model
{
    use Abilities, AvoidsDeletionConflicts, CreatedBy, HasFactory;
    use UpdatesOnTouch, Rememberable;

    protected $guarded = [];

    protected $casts = [
        'is_default' => 'boolean', 'is_billing' => 'boolean',
        'is_shipping' => 'boolean', 'addressable_id' => 'integer',
    ];

    protected $touches = ['addressable'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function locality()
    {
        return $this->belongsTo(Locality::class);
    }

    public function addressable()
    {
        return $this->morphTo();
    }

    public function isDefault(): bool
    {
        return $this->is_default;
    }

    public function label(): ?string
    {
        $locality = $this->locality?->name ?? $this->city;
        $region = $this->region ? __('County').' '.$this->region->name : null;
        $attrs = [$locality, $this->street, $this->postcode, $region];

        return Collection::wrap($attrs)->filter()->implode(', ');
    }

    public function scopeDefault(Builder $query): Builder
    {
        return $query->whereIsDefault(true);
    }

    public function scopeNotDefault(Builder $query): Builder
    {
        return $query->whereIsDefault(false);
    }

    public function scopeForPerson(Builder $query, $personId): Builder
    {
        return $query->for($query, $personId, Person::morphMapKey());
    }

    public function scopeForCompany(Builder $query, $companyId): Builder
    {
        return $query->for($query, $companyId, Company::morphMapKey());
    }

    public function scopeFor(Builder $query, int $addressable_id, string $addressable_type): Builder
    {
        return $query->whereAddressableId($addressable_id)
            ->whereAddressableType($addressable_type);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByDesc('is_default');
    }

    public function store(): void
    {
        DB::transaction(function () {
            $defaultAddress = $this->addressable->address;

            if ($this->is_default) {
                if (! $this->is($defaultAddress)) {
                    $defaultAddress?->update(['is_default' => false]);
                }
            } elseif (! $defaultAddress) {
                $this->is_default = true;
            }

            $this->save();
        });
    }

    public function makeDefault(): void
    {
        DB::transaction(function () {
            $this->addressable->addresses()
                ->whereIsDefault(true)
                ->update(['is_default' => false]);

            $this->update(['is_default' => true]);
        });
    }

    public function toggleBilling(): void
    {
        $this->update(['is_billing' => ! $this->is_billing]);
    }

    public function makeBilling(): void
    {
        $this->update(['is_billing' => true]);
    }

    public function toggleShipping(): void
    {
        $this->update(['is_shipping' => ! $this->is_shipping]);
    }

    public function localize(): array
    {
        $coordinates = (new Coordinates($this))->get();

        $this->update($coordinates);

        return $coordinates;
    }

    public function shouldBeSingle(): bool
    {
        return ! $this->canBeMultiple()
            && $this->addressable->address()->exists();
    }

    public function isNotSingle(): bool
    {
        return $this->canBeMultiple()
            && $this->addressable->addresses()->where('id', '<>', $this->id)->exists();
    }

    public function isLocalized(): bool
    {
        return $this->lat !== null && $this->long !== null;
    }

    private function canBeMultiple(): bool
    {
        return method_exists($this->addressable, 'addresses');
    }
}

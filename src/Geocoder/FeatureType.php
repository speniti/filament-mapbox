<?php

declare(strict_types=1);

namespace Peniti\FilamentMapbox\Geocoder;

enum FeatureType: string
{
    // Individual residential or business addresses.
    case Address = 'address';

    // Special feature type reserved for Japanese addresses.
    case Block = 'block';

    // Generally recognized countries or, in some cases like Hong Kong,
    // an area of quasi-national administrative status that has a
    // designated country code under ISO 3166-1.
    case Country = 'country';

    // Features that are smaller than top-level administrative features but typically
    // larger than cities, in countries that use such an additional layer in postal
    // addressing (for example, prefectures in China).
    case District = 'district';

    // Official sub-city features present in countries where such an additional
    // administrative layer is used in postal addressing, or where such features
    // are commonly referred to in local parlance.
    // Examples include city districts in Brazil and Chile and arrondissements
    // in France.
    case Locality = 'locality';

    // Colloquial sub-city features often referred to in local parlance.
    // Unlike locality features, these typically lack official status
    // and may lack universally agreed-upon boundaries.
    case Neighborhood = 'neighborhood';

    // Typically these are cities, villages, municipalities, etc. They’re usually
    // features used in postal addressing, and are suitable for display in ambient
    // end-user applications where current-location context is needed
    // (for example, in weather displays).
    case Place = 'place';

    // Postal codes used in country-specific national addressing systems.
    case Postcode = 'postcode';

    // Top-level sub-national administrative features, such as states
    // in the United States or provinces in Canada or China.
    case Region = 'region';

    // Sub-unit, suite, or lot within a single parent address. Currently available in the US only.
    case SecondaryAddress = 'secondary_address';

    // Street features which host one or more addresses
    case Street = 'street';
}

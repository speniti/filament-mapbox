import MapboxGeocoder, { GeocoderOptions } from '@mapbox/mapbox-gl-geocoder';
import '@mapbox/mapbox-gl-geocoder/dist/mapbox-gl-geocoder.css';
import { AlpineComponent } from 'alpinejs';
import { GeocodeFeature } from '@mapbox/mapbox-sdk/services/geocoding';

interface Geocoder extends Record<string, unknown> {
  geocoder: MapboxGeocoder|undefined;
  state: AddressInfo|string;
  structured: boolean;

  onResult(event: ResultEvent): void;
}

interface AddressInfo {
  address?: string;
  houseNumber?: string;
  street?: string;
  postcode?: string;
  place?: string;
  region?: string;
  country?: string;
  placeName?: string;
  coords?: number[];
}

interface ResultEvent {
  result: GeocodeFeature;
}

export default function geocoder(
  state: AddressInfo|string,
  options: GeocoderOptions,
  disabled = false
): AlpineComponent<Geocoder> {
  return {
    geocoder: undefined,
    structured: true,
    state,

    init() {
      this.geocoder = new MapboxGeocoder(options)
        .on('result', this.onResult.bind(this));

      this.geocoder.addTo(this.$root);
      this.structured = typeof this.state !== 'string';

      if (this.geocoder._inputEl) {
        this.geocoder._inputEl.value = this.structured
          ? (this.state as AddressInfo).placeName ?? ''
          : this.state as string;

        this.geocoder._inputEl.disabled = disabled;
      }
    },

    onResult({ result }): void {
      if (!this.structured) {
        this.state = result.place_name;

        return;
      }

      this.state = {
        address: result.place_name.split(',')[0],
        houseNumber: result.address,
        street: result.text,
        postcode: result.context.find(ctx => ctx.id.startsWith('postcode'))
          ?.text,
        place: result.context.find(ctx => ctx.id.startsWith('place'))?.text,
        region: result.context.find(ctx => ctx.id.startsWith('region'))?.text,
        country: result.context.find(ctx => ctx.id.startsWith('country'))?.text,
        placeName: result.place_name,
        coords: result.center
      };
    }
  };
}

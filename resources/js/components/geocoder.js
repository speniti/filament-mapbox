import MapboxGeocoder from '@mapbox/mapbox-gl-geocoder';
import { getAddressInfo } from '@mapbox/mapbox-gl-geocoder/lib/utils.js';
import '@mapbox/mapbox-gl-geocoder/dist/mapbox-gl-geocoder.css';

export default function geocoder(state, options) {
  return {
    geocoder: null,
    state,

    async init() {
      this.geocoder = new MapboxGeocoder({
        autocomplete: true,
        fuzzyMatch: true,
        language: document.documentElement.lang,
        types: 'address',
        ...options,
      }).on(
        'result',
        ({ result }) =>
          (this.state = { ...getAddressInfo(result), coords: result.center }),
      );

      this.geocoder.addTo(this.$root);

      if (typeof this.state === 'string') {
        const {
          body: { features },
        } = await this.geocoder.geocoderService
          .forwardGeocode(this.geocoder._setupConfig(0, this.state))
          .send();

        this.state = {
          ...getAddressInfo(features[0]),
          coords: features[0].center,
        };
      }

      if (this.state?.placeName) {
        this.geocoder._inputEl.value = this.state?.placeName;
      }
    },
  };
}

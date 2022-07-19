<?php

namespace ShoppingFlux\Zalando\Enums;

abstract class EWarehouseCapabilities extends AbstractEnum {

  // BEAUTY_ITEMS: The Facility is capable of physically processing/handling beauty items (e.g. cosmetics).
  const BEAUTY_ITEMS = 'BEAUTY_ITEMS';

  // BULKY_ITEMS: The Facility is capable of physically processing/handling bulky items (e.g. furniture).
  const BULKY_ITEMS = 'BULKY_ITEMS';

  // CROSS_DOCKING: The Facility is capable of performing cross-docking.
  const CROSS_DOCKING = 'CROSS_DOCKING';

  // DANGEROUS_GOODS: The Facility is capable of physically processing/handling dangerous items.
  const DANGEROUS_GOODS = 'DANGEROUS_GOODS';

  // INBOUND_ITEM: The Facility is capable of physically receiving items without processing them further.
  const INBOUND_ITEM = 'INBOUND_ITEM';

  // INBOUND_RELOCATION: The Facility is capable of physically receiving relocations without processing them further.
  const INBOUND_RELOCATION = 'INBOUND_RELOCATION';

  // INBOUND_REPLENISHMENT: The Facility is capable of physically receiving replenishments without processing them further.
  const INBOUND_REPLENISHMENT = 'INBOUND_REPLENISHMENT';

  // INBOUND_RETURN: The Facility is capable of physically receiving returns without processing them further.
  const INBOUND_RETURN = 'INBOUND_RETURN';

  // INBOUND_SHIPMENT: The Facility is capable of physically receiving shipments without processing them further.
  const INBOUND_SHIPMENT = 'INBOUND_SHIPMENT';

  // OUTBOUND_RELOCATION: The Facility is capable of physically sending out relocations.
  const OUTBOUND_RELOCATION = 'OUTBOUND_RELOCATION';

  // OUTBOUND_REPLENISHMENT: The Facility is capable of physically sending out replenishments.
  const OUTBOUND_REPLENISHMENT = 'OUTBOUND_REPLENISHMENT';

  // OUTBOUND_RETURN: The Facility is capable of physically sending out returns.
  const OUTBOUND_RETURN = 'OUTBOUND_RETURN';

  // OUTBOUND_SHIPMENT: The Facility is capable of physically sending out shipments.
  const OUTBOUND_SHIPMENT = 'OUTBOUND_SHIPMENT';

  // PRIORITY_OUTBOUND_SHIPMENT: The Facility is capable of prioritizing shipments, when sending them out.
  const PRIORITY_OUTBOUND_SHIPMENT = 'PRIORITY_OUTBOUND_SHIPMENT';

  // SELF_SERVICE: The Facility is not operated by humans.
  const SELF_SERVICE = 'SELF_SERVICE';

  // STORE_ITEM: The Facility is capable of physically storing items.
  const STORE_ITEM = 'STORE_ITEM';

}

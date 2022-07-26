<?php

namespace ShoppingFlux\Zalando\Enums;

abstract class EShippingNoticeStates extends AbstractEnum {

  // INITIAL
  const INITIAL = 'initial';

  // READY FOR DELIVERY DATE
  const READY_FOR_DELIVERY_DATE = 'ready_for_delivery_date';

  // READY FOR DISPATCH
  const READY_FOR_DISPATCH = 'ready_for_dispatch';

  // READY FOR RECEIVE
  const READY_FOR_RECEIVE = 'ready_for_receive';

}

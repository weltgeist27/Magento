/**
Magento 2 Sarp2 Extension. Changing "One-off purchase" (No Subscription)" to "One-Time Purchase ("No subscription" on product page
*/

/public_html/vendor/aheadworks/module-sarp2/Model/Product/Subscription/Option/Source


     * @param IsSubscription $isSubscriptionChecker
     * @param SubscriptionOptionFinder $subscriptionOptionFinder
     * @param PlanChecker $planChecker
     */
    public function __construct(
        IsSubscription $isSubscriptionChecker,
        SubscriptionOptionFinder $subscriptionOptionFinder,
        PlanChecker $planChecker
    ) {
        $this->isSubscriptionChecker = $isSubscriptionChecker;
        $this->subscriptionOptionFinder = $subscriptionOptionFinder;
        $this->planChecker = $planChecker;
    }

    /**
     * Get frontend options
     *
     * @param int $productId
     * @return array
     */
    public function getOptionArray($productId)
    {
        $optionArray = [];
        if (!$this->isSubscriptionChecker->checkById($productId, true)) {
        * Change ('One-off purchase (No subscription)') to ('One-Time Purchase (No subscription)');
            $optionArray[0] = __('One-Time Purchase (No subscription)');
        }

        $options = $this->subscriptionOptionFinder->getSortedOptions($productId);
        foreach ($options as $option) {
            if ($this->planChecker->isEnabled($option->getPlanId())) {
                $optionArray[$option->getOptionId()] = $option->getFrontendTitle();
            }
        }

        return $optionArray;
    }

    /**
     * Get frontend options for plan selection
     *
     * @param int $productId
     * @return array
     */
    public function getPlanOptionArray($productId)
    {
        $optionArray = [];
        $options = $this->subscriptionOptionFinder->getSortedOptions($productId);
        foreach ($options as $option) {
            if ($this->planChecker->isEnabled($option->getPlanId())) {
                $optionArray[$option->getPlanId()] = $option->getFrontendTitle();
            }
        }

        return $optionArray;
    }
}

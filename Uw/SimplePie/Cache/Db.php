<?php

class SimplePie_Cache_DB
{

    function prepare_simplepie_object_for_cache($data)
    {
        $items = $data->get_items();
        $items_by_id = array();

        if (!empty($items)) {
            foreach ($items as $item) {
                $items_by_id[$item->get_id()] = $item;
            }

            if (count($items_by_id) !== count($items)) {
                $items_by_id = array();
                foreach ($items as $item) {
                    $items_by_id[$item->get_id(true)] = $item;
                }
            }

            if (isset($data->data['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['feed'][0])) {
                $channel = & $data->data['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['feed'][0];
            } elseif (isset($data->data['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['feed'][0])) {
                $channel = & $data->data['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['feed'][0];
            } elseif (isset($data->data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF'][0])) {
                $channel = & $data->data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF'][0];
            } elseif (isset($data->data['child'][SIMPLEPIE_NAMESPACE_RSS_20]['rss'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_20]['channel'][0])) {
                $channel = & $data->data['child'][SIMPLEPIE_NAMESPACE_RSS_20]['rss'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_20]['channel'][0];
            } else {
                $channel = null;
            }

            if ($channel !== null) {
                if (isset($channel['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['entry'])) {
                    unset($channel['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['entry']);
                }
                if (isset($channel['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['entry'])) {
                    unset($channel['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['entry']);
                }
                if (isset($channel['child'][SIMPLEPIE_NAMESPACE_RSS_10]['item'])) {
                    unset($channel['child'][SIMPLEPIE_NAMESPACE_RSS_10]['item']);
                }
                if (isset($channel['child'][SIMPLEPIE_NAMESPACE_RSS_090]['item'])) {
                    unset($channel['child'][SIMPLEPIE_NAMESPACE_RSS_090]['item']);
                }
                if (isset($channel['child'][SIMPLEPIE_NAMESPACE_RSS_20]['item'])) {
                    unset($channel['child'][SIMPLEPIE_NAMESPACE_RSS_20]['item']);
                }
            }
            if (isset($data->data['items'])) {
                unset($data->data['items']);
            }
            if (isset($data->data['ordered_items'])) {
                unset($data->data['ordered_items']);
            }
        }
        return array(serialize($data->data), $items_by_id);

    }

}
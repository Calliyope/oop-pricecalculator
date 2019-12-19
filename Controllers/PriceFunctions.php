<?php

function getGroupsForCustomer($customer, $groups) {
    $customerGroups = array();

    $directGroup = getGroupById($customer->group_id, $groups);
    array_push($customerGroups, $directGroup);

    $parentGroup = getGroupById($directGroup->parent_group_id, $groups);

    if($parentGroup != null) {
        array_push($customerGroups, $parentGroup);
    }

    return $customerGroups;
}

function getGroupById($groupId, $groups) {
    foreach($groups as $group) {
        if($group->id == $groupId) {
            return $group;
        }
    }

    return null;
}




function getHighestVariableDiscount($groups) {
    // If no groups, then zero
        // no array
        // empty array with 0 items

    if(empty($groups) || count($groups) == 0) {
        return 0;
    }    
    
    // If one group, 

    if( count($groups) == 1 ) {
        // then just get that value
        return $groups[0]->variable_discount;
    }

    // If two groups, compare the first value and the second value and 

    if( count($groups) == 2 ) {
        $firstValue = $groups[0]->variable_discount;
        $secondValue = $groups[1]->variable_discount;

        // return the highest of the two

        if($firstValue > $secondValue) {
            return $firstValue;
        }
        else {
            return $secondValue;
        }
    }    
}

function getHighestVariableDiscount_version2($groups) {
    
    $highestVariableDiscountSeenSoFar = 0;
    
    foreach($groups as $group) {
        if(property_exists($group, 'variable_discount')) {
            if($group->variable_discount > $highestVariableDiscountSeenSoFar) {
                $highestVariableDiscountSeenSoFar = $group->variable_discount;
            }
        }
    }

    return $highestVariableDiscountSeenSoFar;
}

function getFixedDiscountSum($groups) {

    $sum = 0;
    
    foreach($groups as $group) {
        if(property_exists($group, 'fixed_discount')) {
            $sum += $group->fixed_discount;
        }
    }

    return $sum;
}


function calculateFixedDiscountPrice($price, $fixedDiscount) {

    $newPrice = $price - $fixedDiscount;

    if($newPrice < 0)
        $newPrice = 0;

    $newPrice = round($newPrice, 2);

    return $newPrice;

}

function calculateVariableDiscountPrice($price, $variableDiscount) {
    
    $newPrice = $price * ((100 - $variableDiscount) / 100);

    $newPrice = round($newPrice, 2);

    return $newPrice;
}



?>
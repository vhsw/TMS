<?php

namespace App\Http\Traits;

//use Helper;
use Illuminate\Database\Eloquent\Model;

trait InventoryTrait
{
    /*
     * Common Helper Methods
     */
    use BaseTrait;


    abstract public function category();

    abstract public function costs();

    abstract public function pictures();

    abstract public function details();

    abstract public function barcode();

    abstract public function stocks();

    abstract public function supplier();

    /**
     * Overrides the models boot function
     */
    public static function bootInventoryTrait()
    {
       
    }

    /**
     * Returns an item record by the specified Barcode.
     *
     * @param string $barcode
     *
     * @return bool
     */
    public static function findByBarcode($barcode)
    {
        /*
         * Create a new static instance
         */
        $instance = new static();

        /*
         * Try and find the Barcode
         */
        $barcode = $instance
            ->barcode()
            ->getRelated()
            ->with('tool')
            ->where('barcode', $barcode)
            ->first();

        /*
         * Check if the Barcode was found, and if a tool is
         * attached to the Barcode we'll return it
         */
        if ($barcode && $barcode->tool) {
            return $barcode->tool;
        }

        /*
         * Return false on failure
         */
        return false;
    }

    /**
     * Returns an instant search item by the specified Barcode.
     *
     * @param string $barcode
     *
     * @return array
     */
    public static function getItemByInstantSearch($barcode, $searchstr = "")
    {
        $tool = parent::findByBarcode($barcode);

        if($tool) {
            $result = parent::with(['pictures' => function($query) {
                $query->where('first_choice', 1); }])
            ->with('stocks', 'supplier', 'category')
            ->where('id', $tool->id)
            ->first();
            return $result;
        }
        return;
    }

    /**
     * Returns the total sum of the current item stock.
     *
     * @return int|float
     */
    public function getTotalStock()
    {
        $quantity = 0;
        foreach ($this->stocks as $stock)
        {
            $quantity = $quantity + $stock->pivot->quantity;
        }

        return $quantity;
    }

    /**
     * Returns the item's Barcode.
     *
     * @return null|string
     */
    public function getBarcode()
    {
        if ($this->hasBarcode()) {
            return $this->barcode->getAttribute('barcode');
        }

        return;
    }

    /**
     * Returns true/false if it has Barcode
     *
     * @return bool
     */
    public function hasBarcode()
    {
        if ($this->barcode) {
            return true;
        }

        return false;
    }

    /**
     * Returns true/false if it has Category
     *
     * @return bool
     */
    public function hasCategory()
    {
        if ($this->barcode) {
            return true;
        }

        return false;
    }

    /**
     * Returns true/false if it has Pictures
     *
     * @return bool
     */
    public function hasPicture()
    {
        if ($this->pictures) {
            return true;
        }

        return false;
    }

    /**
     * Returns true/false if the inventory has stock.
     *
     * @return bool
     */
    public function isInStock()
    {
        return ($this->getTotalStock() > 0 ? true : false);
    }

    /**
     * Returns true/false if the inventory has stock.
     *
     * @return bool
     */
    public function getPreferredToolPicture()
    {
        if ($this->hasPicture()) {
            return $this->pictures()->wherePivot('first_choice', '=', '1')->first();
        }

        return;
    }

    /**
     * Creates a Barcode. 
     *
     * @param string $code
     *
     * @return bool
     */
    public function createBarcode($code)
    {
        // Get the current Barcode record
        $barcode = $this->barcode()->first();

        if ($barcode) {
            // Barcode exists, update
            return $this->updateBarcode($code, $barcode);
        }

        // No Barcode exists, create one
        return $this->processBarcodeCreate($this->getKey(), $code);
    }

    /**
     * Updates the items current Barcode or the Barcode
     * supplied with the specified code.
     *
     * @param string $code
     * @param null   $barcode
     *
     * @return mixed|bool
     */
    public function updateBarcode($code, $barcode = null)
    {
        // Get the current Barcode record if one isn't supplied
        if (!$barcode) {
            $barcode = $this->barcode()->first();
        }

        /*
         * If a Barcode still doesn't exist after
         * trying to find one, we'll create one
         */
        if (!$barcode) {
            return $this->processBarcodeCreate($this->getKey(), $code);
        }

        return $this->processBarcodeUpdate($barcode, $code);
    }

    /**
     * Processes a Barcode generation.
     *
     * @param int|string $inventoryId
     * @param string     $code
     *
     * @return bool|mixed
     */
    private function processBarcodeCreate($inventoryId, $code)
    {
        $barcode = $this->barcode()->getRelated()->newInstance();

        $barcode->setAttribute('tool_id', $inventoryId);
        $barcode->setAttribute('barcode', $code);
        $barcode->save();

        return $barcode;
    }

    /**
     * Processes updating the specified Barcode
     * record with the specified code.
     *
     * @param Model  $barcode
     * @param string $code
     *
     * @return mixed|bool
     */
    private function processBarcodeUpdate(Model $code, $barcode)
    {
        $code->update(compact('barcode'));

        return $code;   
    }
}

<?php
namespace sideshow_bob\examples\redmine;

use Redmine\Client;
use sideshow_bob\Model\AbstractModel;
use sideshow_bob\Model\Connection\ConnectionManager;
use sideshow_bob\Model\Connection\ConnectionManagerException;
use sideshow_bob\Model\Model;
use sideshow_bob\Model\RecordNotFoundException;
use Stringy\StaticStringy;

/**
 * Model which provides basic safe and delete methods for the redmine api.
 * @package LAOLA1\Redmine
 */
abstract class AbstractRedmineModel extends AbstractModel
{
    /**
     * The connection identifier used for the ConnectionManager.
     */
    const CONNECTION_NAME = "redmine";

    /** @var int */
    protected $id;

    /** @var Client $client */
    protected $client;

    /**
     * AbstractRedmineModel constructor.
     * @param Client $client
     * @param int $id [optional] id of the model
     */
    public function __construct(Client $client, $id = null)
    {
        parent::__construct($id === null);
        $this->client = $client;
        $this->id = $id;
    }

    /**
     * @inheritdoc
     */
    public function dirtyAttributeValues()
    {
        $params = [];
        foreach ($this->dirtyAttributes() as $attribute) {
            $key = (string)StaticStringy::underscored($attribute);
            if ($this->$attribute instanceof Model) {
                $params[$key . "_id"] = $this->$attribute->id;
            } else {
                $params[$key] = $this->$attribute;
            }
        }
        return $params;
    }

    /**
     * @inheritdoc
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        if (!$this->isDirty()) {
            // we need a dirty model to save it
            throw new RecordNotFoundException("Model is not dirty and cannot be saved.");
        }
        // actually save the record
        $this->doSave();
        // reset the dirty attributes
        $this->resetDirty();
        // and mark the model as persistent
        $this->setPersisted();
    }

    /**
     * Save the entity and return it's id.
     */
    abstract protected function doSave();

    /**
     * @inheritdoc
     */
    public function delete()
    {
        if ($this->isNew()) {
            // if the model has not been saved we do not delete it
            throw new RecordNotFoundException("The model has yet to be persisted");
        }
        $this->client->issue->remove($this->id);
    }

    /**
     * Get the current redmine client.
     * @param string $name [optional] connection name
     * @return Client
     * @throws \sideshow_bob\Model\Connection\ConnectionManagerException
     */
    protected static function getClient($name = self::CONNECTION_NAME)
    {
        $client = ConnectionManager::get($name);
        if ($client instanceof Client) {
            return $client;
        }
        throw new ConnectionManagerException("The fetched exception is not an instance of 'Redmine\\Client'");
    }
}

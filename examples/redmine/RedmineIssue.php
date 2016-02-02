<?php
namespace sideshow_bob\examples\redmine;

use Redmine\Client;
use sideshow_bob\Model\RecordNotFoundException;

/**
 * Issue model.
 * @package LAOLA1\Redmine
 */
final class RedmineIssue extends AbstractRedmineModel implements Issue
{
    protected $subject;
    protected $description;
    protected $startDate;
    protected $dueDate;
    protected $doneRatio;
    protected $estimatedHours;
    protected $createdOn;
    protected $updatedOn;

    protected $project;
    protected $tracker;
    protected $status;
    protected $priority;
    protected $author;
    protected $category;
    protected $assignedTo;

    /**
     * @inheritdoc
     */
    protected function doSave()
    {
        if ($this->isNew()) {
            $this->id = $this->client->issue->create($this->dirtyAttributeValues())->id;
        } else {
            $this->client->issue->update($this->id, $this->dirtyAttributeValues());
        }
    }

    /**
     * @inheritdoc
     */
    public static function find($id)
    {
        // fetch the issue data by using the default connection
        $client = static::getClient();
        // create an instance and return it
        return static::factory($client, $client->issue->show($id)["issue"]);
    }

    /**
     * @inheritdoc
     */
    public static function query()
    {
        return new RedmineIssueQuery(static::getClient());
    }

    /**
     * @inheritdoc
     */
    public static function where($attribute, $operator = null, $value = null, $connector = "and")
    {
        return static::query()->where($attribute, $operator, $value, $connector)->get();
    }

    /**
     * @inheritdoc
     * @param Client $client
     * @param array $data
     */
    public static function factory($client = null, array $data = null)
    {
        // argument validation
        if (empty($client)) {
            // use the default client if none is given
            $client = static::getClient();
        }
        if (empty($data)) {
            throw new RecordNotFoundException("No model data given");
        }

        // create an instance
        $i = new RedmineIssue($client, $data["id"]);
        // general attributed
        $i->subject = $data["subject"];
        $i->description = isset($data["description"]) ? $data["description"] : null;
        $i->startDate = isset($data["start_date"]) ? new \DateTime($data["start_date"]) : null;
        $i->dueDate = isset($data["due_date"]) ? new \DateTime($data["due_date"]) : null;
        $i->doneRatio = (int)$data["done_ratio"] / 100;
        $i->estimatedHours = isset($data["estimated_hours"]) ? $data["estimated_hours"] : null;
        $i->createdOn = new \DateTime($data["created_on"]);
        $i->updatedOn = new \DateTime($data["updated_on"]);
        // relations, currently only the id of each relation is saved
        $i->project = $data["project"]["id"];
        $i->tracker = $data["tracker"]["id"];
        $i->status = $data["status"]["id"];
        $i->priority = $data["priority"]["id"];
        $i->author = $data["author"]["id"];
        $i->category = isset($data["category"]) ? $data["category"]["id"] : null;
        $i->assignedTo = isset($data["assigned_to"]) ? $data["assigned_to"]["id"] : null;

        // return it
        return $i;
    }
}

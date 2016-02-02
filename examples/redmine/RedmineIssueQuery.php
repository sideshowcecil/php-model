<?php
namespace sideshow_bob\examples\redmine;

class RedmineIssueQuery extends AbstractRedmineQuery
{
    /**
     * @inheritdoc
     */
    public function get()
    {
        // execute the api call
        $issues = $this->client->issue->all($this->buildParams());
        if (!isset($issues["issues"])) {
            // we got not results
            return [];
        }
        // return model instances
        return array_map(
            function ($data) {
                return RedmineIssue::factory($this->client, $data);
            },
            $issues["issues"]
        );
    }
}

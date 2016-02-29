<?php

namespace App\Storages;

use App\Contracts\Storages\GraphStorageContract;
use App\Models\Swap;
use Everyman\Neo4j;

class GraphStorage implements GraphStorageContract
{
    /**
     * @var Neo4j\Client
     */
    private $neo4j;

    /**
     * GraphStorage constructor.
     * @param Neo4j\Client $neo4j
     */
    public function __construct(Neo4j\Client $neo4j)
    {
        $this->neo4j = $neo4j;
    }

    public function add(Swap $swap)
    {
        $swapsIndex = new Neo4j\Index\NodeIndex($this->neo4j, 'swaps');
        $swapsIndex->save();

        $swapNode = $this->neo4j->makeNode([
            'id' => $swap->id,
            'name' => $swap->name
        ]);
        $swapNode->save();

        $labels = [];
        foreach ($swap->tags() as $tag) {
            $labels[] = $tag->name;
        }

        foreach ($swap->keywords() as $keyword) {
            $labels[] = $keyword->name;
        }

        if (!empty($labels)) {
            $swapNode->addLabels($labels);
        }

        $swapsIndex->add($swapNode, 'id', $swap->id);
    }

    public function find($id)
    {
        $swapsIndex = new Neo4j\Index\NodeIndex($this->neo4j, 'swaps');

        return $swapsIndex->findOne('id', $id);
    }

    public function connectSwaps(Swap $swapA, Swap $swapB)
    {
        $nodeA = $this->find($swapA->id);
        $nodeB = $this->find($swapB->id);

        if (!$nodeA || !$nodeB) {
            return false;
        }

        $nodeA->relateTo($nodeB, 'SATISFIED_BY')->save();
        $nodeB->relateTo($nodeA, 'SATISFIED_BY')->save();

        return true;
    }

    public function getPath(Swap $swapA, Swap $swapB)
    {
        $nodeA = $this->find($swapA->id);
        $nodeB = $this->find($swapB->id);
        $query = 'START a=node('.$nodeA->getId().'), d=node('.$nodeB->getId().') MATCH p=a-[r*..]-d return p';
        $this->neo4j->executeCypherQuery(new Neo4j\Cypher\Query($query));
    }
}

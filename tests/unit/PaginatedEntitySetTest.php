<?php


    namespace Tests\Fei\Entity;

    use Codeception\Test\Unit;
    use Fei\Entity\PaginatedEntitySet;

    class PaginatedEntitySetTest extends Unit
    {
        public function testCurrentPageAccessors()
        {
            $set = new PaginatedEntitySet();

            $set->setCurrentPage(3);

            $this->assertEquals(3, $set->getCurrentPage());
        }
    
        public function testPerPageAccessors()
        {
            $set = new PaginatedEntitySet();
        
            $set->setPerPage(10);
        
            $this->assertEquals(10, $set->getPerPage());
        }
    
        public function testTotalAccessors()
        {
            $set = new PaginatedEntitySet();
        
            $set->setTotal(38);
        
            $this->assertEquals(38, $set->getTotal());
        }
    }

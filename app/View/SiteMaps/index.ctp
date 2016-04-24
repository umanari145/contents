 <url>
 　　<loc>http://jk-station.net/</loc>
 　　<changefreq>daily</changefreq>
 　　<priority>1.0</priority>
 </url>
 <?php foreach ($item as $data):?>
 　　　　<url>
 　　　　　　　　<loc>http://jk-station.net/items/view/<?php echo $data['Item']['id']; ?>/</loc>
 　　　　　　　　<lastmod><?php echo $this->Time->toAtom($data['Item']['modified']); ?></lastmod>
 　　            <changefreq>daily</changefreq>
 　　　　　　　　<priority>0.6</priority>
 　　　　</url>
 <?php endforeach; ?>

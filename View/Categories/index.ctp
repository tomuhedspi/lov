  <h2>Categories</h2>
  <p>All Categories You Have :</p>    
  
  <div class="col-md-6"
  <h4 Income Categories />
  <table class="table table-hover"
    <thead>
      <tr>
        <th>Name</th>
        <th>Type</th>
        <th>Note</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach ($incomeList as $category): ?>
                        <tr>
                            <td><?php echo $category['Category']['name']; ?></td>
                            <td><?php if($category['Category']['type']==1){ echo'Income'; }else{ echo'Expens';}  ?></td>
                            <td><?php echo $category['Category']['note']; ?></td>
                        </tr>
        <?php endforeach; ?>
    </tbody>
  </table>
</div>
  
 <div class="col-md-6"
<h4 Income Categories />
  <table class="table table-hover"
    <thead>
      <tr>
        <th>Name</th>
        <th>Type</th>
        <th>Note</th>
      </tr>
    </thead>
    <tbody>
  
       

    </tbody>
  </table>
</div>
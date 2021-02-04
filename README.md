# Laravel-Practice
Laravel Template


Access PHP Object in Javascript
------------------------------------

##### In controller:
```
compact('user')
^ Illuminate\Support\Collection {#1839 ▼
  #items: array:1 [▼
    0 => {#1831 ▼
      +"count": 543
    }
  ]
}
```

##### In Javascript
```
<script>
    var dataSet = @json($users ?? '');
    alert(dataSet[0]['count']);
</script>
``

# Benchmarks for PHP functions

This repository contains benchmarks for PHP library functions.

### Serialisation benchmarks

This benchmark shows the performance of the PHP serialisation functions and also payload size.

- Native json_encode() and json_decode() functions
- Native serialize() and unserialize() functions
- Igbinary extension
- Valinor
- Protobuf
- Laravel SerializableClosure
- [Symfony Serializer Component](https://symfony.com/doc/current/components/serializer.html).

```bash
php app.php bench:serializers --iterations=10000
```

#### Results
```bash
Data Encoding

 ------- ---------------------- ---------------------- ---------------------- ---------------------- ------------------------- -------------------------- ---------------------- ----------------------- ------------------------ ---------------------- --------------------------- ----------------------------
  #       JSON array             JSON object            Ig Binary array        Ig Binary object       Native serializer array   Native serializer object   Protobuf object        Symfony array           Symfony object           Valinor array          SerializableClosure array   SerializableClosure object
 ------- ---------------------- ---------------------- ---------------------- ---------------------- ------------------------- -------------------------- ---------------------- ----------------------- ------------------------ ---------------------- --------------------------- ----------------------------
  min     0.00092 ms - 0 bytes   0.00097 ms - 0 bytes   0.00108 ms - 0 bytes   0.00122 ms - 0 bytes   0.00089 ms - 0 bytes      0.00105 ms - 0 bytes       0.00059 ms - 0 bytes   0.0203 ms - 0 bytes     0.10181 ms - 0 bytes     0.00098 ms - 0 bytes   0.00997 ms - 0 bytes        0.03151 ms - 0 bytes
  max     0.13357 ms - 0 bytes   0.00183 ms - 0 bytes   0.00667 ms - 0 bytes   0.00922 ms - 0 bytes   0.00447 ms - 0 bytes      0.00344 ms - 0 bytes       0.0088 ms - 0 bytes    0.32826 ms - 2.00 MB    0.17658 ms - 0 bytes     0.00422 ms - 0 bytes   0.03579 ms - 0 bytes        0.12458 ms - 0 bytes
  avg     0.001 ms - 0 bytes     0.00106 ms - 0 bytes   0.00115 ms - 0 bytes   0.0019 ms - 0 bytes    0.00096 ms - 0 bytes      0.00111 ms - 0 bytes       0.00063 ms - 0 bytes   0.02103 ms - 0 bytes    0.10659 ms - 0 bytes     0.00106 ms - 0 bytes   0.01023 ms - 0 bytes        0.03221 ms - 0 bytes
  total   5.48794 ms - 0 bytes   4.15794 ms - 0 bytes   4.83834 ms - 2.00 MB   4.944 ms - 0 bytes     3.98199 ms - 0 bytes      4.29533 ms - 0 bytes       3.58858 ms - 0 bytes   25.34349 ms - 2.00 MB   112.33992 ms - 0 bytes   5.75869 ms - 0 bytes   14.06173 ms - 0 bytes       37.0032 ms - 0 bytes
 ------- ---------------------- ---------------------- ---------------------- ---------------------- ------------------------- -------------------------- ---------------------- ----------------------- ------------------------ ---------------------- --------------------------- ----------------------------
  Order   - 3 -                  - 4 -                  - 7 -                  - 8 -                  - 2 -                     - 6 -                      - 1 -                  - 10 -                  - 12 -                   - 5 -                  - 9 -                       - 11 -
 ------- ---------------------- ---------------------- ---------------------- ---------------------- ------------------------- -------------------------- ---------------------- ----------------------- ------------------------ ---------------------- --------------------------- ----------------------------

Data Decoding

 ------- ---------------------- ---------------------- ---------------------- ---------------------- ------------------------- -------------------------- ---------------------- ----------------------- ----------------------- ------------------------ --------------------------- ----------------------------
  #       JSON array             JSON object            Ig Binary array        Ig Binary object       Native serializer array   Native serializer object   Protobuf object        Symfony array           Symfony object          Valinor array            SerializableClosure array   SerializableClosure object
 ------- ---------------------- ---------------------- ---------------------- ---------------------- ------------------------- -------------------------- ---------------------- ----------------------- ----------------------- ------------------------ --------------------------- ----------------------------
  min     0.00261 ms - 0 bytes   0.0026 ms - 0 bytes    0.00119 ms - 0 bytes   0.00198 ms - 0 bytes   0.00133 ms - 0 bytes      0.00224 ms - 0 bytes       0.00137 ms - 0 bytes   0.06613 ms - 0 bytes    0.06661 ms - 0 bytes    0.20272 ms - 0 bytes     0.01709 ms - 0 bytes        0.03706 ms - 0 bytes
  max     0.01227 ms - 0 bytes   0.00535 ms - 0 bytes   0.03775 ms - 0 bytes   0.02017 ms - 0 bytes   0.12396 ms - 0 bytes      0.1068 ms - 0 bytes        0.02317 ms - 0 bytes   0.75286 ms - 0 bytes    0.16183 ms - 0 bytes    1.88834 ms - 0 bytes     0.26208 ms - 0 bytes        0.16979 ms - 0 bytes
  avg     0.00281 ms - 0 bytes   0.00304 ms - 0 bytes   0.0015 ms - 0 bytes    0.00232 ms - 0 bytes   0.00225 ms - 0 bytes      0.00268 ms - 0 bytes       0.00142 ms - 0 bytes   0.06902 ms - 0 bytes    0.06898 ms - 0 bytes    0.21545 ms - 0 bytes     0.01785 ms - 0 bytes        0.04083 ms - 0 bytes
  total   6.1935 ms - 0 bytes    6.10782 ms - 0 bytes   4.66907 ms - 0 bytes   5.49897 ms - 0 bytes   5.92023 ms - 0 bytes      6.31746 ms - 0 bytes       4.70763 ms - 0 bytes   76.47717 ms - 0 bytes   74.49863 ms - 0 bytes   228.47132 ms - 0 bytes   22.71963 ms - 0 bytes       45.79335 ms - 0 bytes
 ------- ---------------------- ---------------------- ---------------------- ---------------------- ------------------------- -------------------------- ---------------------- ----------------------- ----------------------- ------------------------ --------------------------- ----------------------------
  Order   - 6 -                  - 7 -                  - 2 -                  - 4 -                  - 3 -                     - 5 -                      - 1 -                  - 11 -                  - 10 -                  - 12 -                   - 8 -                       - 9 -
 ------- ---------------------- ---------------------- ---------------------- ---------------------- ------------------------- -------------------------- ---------------------- ----------------------- ----------------------- ------------------------ --------------------------- ----------------------------

Data Size in Bytes
+------------+-------------+-----------------+------------------+-------------------------+--------------------------+-----------------+---------------+----------------+---------------+---------------------------+----------------------------+
| JSON array | JSON object | Ig Binary array | Ig Binary object | Native serializer array | Native serializer object | Protobuf object | Symfony array | Symfony object | Valinor array | SerializableClosure array | SerializableClosure object |
+------------+-------------+-----------------+------------------+-------------------------+--------------------------+-----------------+---------------+----------------+---------------+---------------------------+----------------------------+
| 430        | 430         | 348             | 482              | 635                     | 848                      | 193             | 430           | 430            | 430           | 961                       | 1174                       |
+------------+-------------+-----------------+------------------+-------------------------+--------------------------+-----------------+---------------+----------------+---------------+---------------------------+----------------------------+
```

### Containers benchmarks

This benchmark shows the performance of the PHP dependency injection containers.

- [Symfony Dependency Injection Container](https://symfony.com/doc/current/components/dependency_injection.html)
- [PHP-DI](http://php-di.org/)
- Laravel Container
- Spiral Container
- Yii3 Container
- League Container

```bash
php app.php bench:containers --iterations=10000
```

#### Results
```bash
Benching container performance with getting by name.
 ------- -------------------------- ---------------------------------- -------------------------- -------------------------- -------------------------- --------------------------
  #       Spiral                     Yii                                Laravel                    League                     Symfony                    PHP DI
 ------- -------------------------- ---------------------------------- -------------------------- -------------------------- -------------------------- --------------------------
  min     0.002976 ms - 0 bytes      0.000651 ms - 0 bytes              0.001793 ms - 0 bytes      0.002365 ms - 0 bytes      0.001292 ms - 0 bytes      0.000561 ms - 0 bytes
  max     0.061946 ms - 0 bytes      0.657383 ms - 0 bytes              0.100278 ms - 0 bytes      0.721804 ms - 2.00 MB      0.038412 ms - 0 bytes      1.614008 ms - 0 bytes
  avg     0.003289454 ms - 0 bytes   0.00074492599999999 ms - 0 bytes   0.001965198 ms - 0 bytes   0.002720537 ms - 0 bytes   0.001394952 ms - 0 bytes   0.000651637 ms - 0 bytes
  total   211.385251 ms - 4.00 MB    179.869189 ms - 4.00 MB            193.79833 ms - 4.00 MB     202.094357 ms - 4.00 MB    201.046873 ms - 4.00 MB    182.343351 ms - 4.00 MB
 ------- -------------------------- ---------------------------------- -------------------------- -------------------------- -------------------------- --------------------------
  Order   - 6 -                      - 2 -                              - 4 -                      - 5 -                      - 3 -                      - 1 -
 ------- -------------------------- ---------------------------------- -------------------------- -------------------------- -------------------------- --------------------------

Benching container performance with autowiring.
 ------- -------------------------- -------------------------- -------------------------- -------------------------- --------------------------
  #       Spiral                     Yii                        Laravel                    League                     PHP DI
 ------- -------------------------- -------------------------- -------------------------- -------------------------- --------------------------
  min     0.035256 ms - 0 bytes      0.007735 ms - 0 bytes      0.018985 ms - 0 bytes      0.02118 ms - 0 bytes       0.00534 ms - 0 bytes
  max     0.221496 ms - 0 bytes      1.138135 ms - 0 bytes      0.363272 ms - 0 bytes      0.62881 ms - 0 bytes       1.027497 ms - 0 bytes
  avg     0.037867412 ms - 0 bytes   0.008283834 ms - 0 bytes   0.020277138 ms - 0 bytes   0.022836258 ms - 0 bytes   0.005759382 ms - 0 bytes
  total   571.741785 ms - 0 bytes    261.904161 ms - 0 bytes    385.299841 ms - 0 bytes    424.260258 ms - 0 bytes    237.05475 ms - 0 bytes
 ------- -------------------------- -------------------------- -------------------------- -------------------------- --------------------------
  Order   - 5 -                      - 2 -                      - 3 -                      - 4 -                      - 1 -
 ------- -------------------------- -------------------------- -------------------------- -------------------------- --------------------------
```

### Dot getter benchmarks

This benchmark shows the performance of the PHP functions to get a value from a nested array.

- Laravel Arr::get()
- Spiral Dot Getter
- Yii3 ArrayHelper::getValueByPath()

```bash
php app.php bench:dot-get --iterations=10000
```

#### Results

```bash
 ------- -------------------------- -------------------------- -------------------------
  #       Spiral                     Yii                        Laravel
 ------- -------------------------- -------------------------- -------------------------
  min     0.004098 ms - 0 bytes      0.023695 ms - 0 bytes      0.008105 ms - 0 bytes
  max     0.517641 ms - 2.00 MB      1.585564 ms - 2.00 MB      1.17793 ms - 2.00 MB
  avg     0.004604882 ms - 0 bytes   0.025060506 ms - 0 bytes   0.00878889 ms - 0 bytes
  total   212.07033 ms - 4.00 MB     413.049761 ms - 4.00 MB    246.269149 ms - 4.00 MB
 ------- -------------------------- -------------------------- -------------------------
  Order   - 1 -                      - 3 -                      - 2 -
 ------- -------------------------- -------------------------- -------------------------
```
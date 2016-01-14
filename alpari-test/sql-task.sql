-- Имеется таблица ticks вида:
--
-- id symbol date value
--
-- 1 EURUSD 2014-01-10 1.34
--
-- 2 GBPUSD 2014-01-10 1.67
--
-- … … … …
--
-- 50 EURUSD 2014-01-09 1.31
--
-- 51 NZDUSD 2014-01-09 0.83
--
-- В таблице содержатся данные со значениями валютных пар на разные даты.
-- Набор валютных пар ограничен – предположим, что их около 50 штук.
-- Данные в таблице обновляются каждый день, но может случиться так,
-- что в какой-то из дней нет данных по некоторым валютным парам.
-- Необходимо написать запрос, который получит самые «свежие» значения по каждой валютной паре.
-- Если за текущий день значения по какой-то из валютных пар отсутствует,
-- то необходимо выбрать предыдущее значение, и т.д. В результате должна получиться таблица вида:
--
-- EURUSD 1.34
--
-- GBPUSD 1.67
--
-- NZDUSD 0.83
--
-- … …

-- MySQL, PostgreSQL --
SELECT symbol, value FROM ticks
WHERE id IN (
  SELECT MAX( id )
  FROM ticks
  GROUP BY symbol
)

-- MySQL, PostgreSQL --
SELECT t0.symbol, t0.value
FROM ticks t0
JOIN (
  SELECT max(id) as id
  FROM ticks
  GROUP BY symbol
) t1 ON t0.id = t1.id

-- PostgreSQL --
SELECT
  distinct(symbol),
  max(value) over(PARTITION BY symbol ORDER BY date DESC)
FROM ticks

-- PostgreSQL --
WITH symbols AS (
  SELECT max(id) as id
  FROM ticks
  GROUP BY symbol
)
SELECT symbol, value
FROM ticks, symbols
WHERE ticks.id IN (symbols.id)

import hashlib
import sys
import time

def timing(f):
    def wrap(*args):
        time1 = time.time()
        ret = f(*args)
        time2 = time.time()
        print('%s Time: %0.3f s' % (f.__name__, float(time2 - time1)))
        return ret

    return wrap


@timing
def decryptMD5(testHash):
    s = []

    while True:
        m = hashlib.md5()
        for c in s:
            m.update(chr(c).encode("utf-8"))

        hash = m.hexdigest()
        if hash == testHash:
            return ''.join([chr(c) for c in s])

        wrapped = True
        for i in range(0, len(s)):
            s[i] = (s[i] + 1) % 256

            if s[i] != 0:
                wrapped = False
                break

        if wrapped:
            s.append(0)
